<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    protected $client;
    protected $calendarId;
    protected $serviceAccountEmail;

    public function __construct()
    {
        $this->calendarId = env('GOOGLE_CALENDAR_ID');
        $this->serviceAccountEmail = env('GOOGLE_SERVICE_ACCOUNT_EMAIL');

        $this->client = new Client();
        $this->client->setApplicationName('Parudeesa Resort Booking');
        $this->client->setScopes(Calendar::CALENDAR_EVENTS);
        $this->client->setAuthConfig(storage_path('app/google-credentials.json'));
        $this->client->setSubject($this->serviceAccountEmail);
    }

    public function createEvent($booking)
    {
        try {
            $service = new Calendar($this->client);

            $event = new Event([
                'summary' => "Booking: {$booking->name} - {$booking->property->name}",
                'description' => $this->buildEventDescription($booking),
                'start' => new EventDateTime([
                    'dateTime' => $booking->check_in->setTimezone('Asia/Kolkata')->toAtomString(),
                    'timeZone' => 'Asia/Kolkata',
                ]),
                'end' => new EventDateTime([
                    'dateTime' => $booking->check_out->setTimezone('Asia/Kolkata')->toAtomString(),
                    'timeZone' => 'Asia/Kolkata',
                ]),
            ]);

            $createdEvent = $service->events->insert($this->calendarId, $event);

            Log::info('Google Calendar event created', [
                'booking_id' => $booking->id,
                'event_id' => $createdEvent->id,
            ]);

            return $createdEvent;

        } catch (\Exception $e) {
            Log::error('Failed to create Google Calendar event', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function buildEventDescription($booking)
    {
        return "Booking ID: {$booking->id}\n" .
               "Customer: {$booking->name}\n" .
               "Email: {$booking->email}\n" .
               "Phone: {$booking->phone}\n" .
               "Property: {$booking->property->name}\n" .
               "Check-in: {$booking->check_in->format('Y-m-d H:i')}\n" .
               "Check-out: {$booking->check_out->format('Y-m-d H:i')}\n" .
               "Guests: {$booking->guests}\n" .
               "Amount: ₹{$booking->amount}\n" .
               "Status: {$booking->status}\n" .
               "Event Type: {$booking->event_type}\n" .
               "Package: {$booking->package_name}";
    }

    // Future methods for update and delete
    public function updateEvent($eventId, $booking)
    {
        // Implementation for updating event
    }

    public function deleteEvent($eventId)
    {
        try {
            $service = new Calendar($this->client);
            $service->events->delete($this->calendarId, $eventId);
            Log::info('Google Calendar event deleted', ['event_id' => $eventId]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to delete Google Calendar event', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Blocked Dates Support
    |--------------------------------------------------------------------------
    */

    public function createBlockedDate(\App\Models\BlockedDate $blockedDate)
    {
        try {
            $service = new Calendar($this->client);

            $event = new Event([
                'summary' => "{$blockedDate->reason} - {$blockedDate->property->name}",
                'description' => "Reason: {$blockedDate->reason}\nProperty: {$blockedDate->property->name}\nNotes: {$blockedDate->notes}\nCreated By: {$blockedDate->creator->name}",
                'start' => new EventDateTime([
                    'dateTime' => \Carbon\Carbon::parse($blockedDate->start_date)->startOfDay()->setTimezone('Asia/Kolkata')->toAtomString(),
                    'timeZone' => 'Asia/Kolkata',
                ]),
                'end' => new EventDateTime([
                    'dateTime' => \Carbon\Carbon::parse($blockedDate->end_date)->endOfDay()->setTimezone('Asia/Kolkata')->toAtomString(),
                    'timeZone' => 'Asia/Kolkata',
                ]),
                'colorId' => $this->getColorForReason($blockedDate->reason),
            ]);

            $createdEvent = $service->events->insert($this->calendarId, $event);

            Log::info('Google Calendar blocked date created', [
                'blocked_date_id' => $blockedDate->id,
                'event_id' => $createdEvent->id,
            ]);

            return $createdEvent;

        } catch (\Exception $e) {
            Log::error('Failed to create Google Calendar blocked date', [
                'blocked_date_id' => $blockedDate->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function updateBlockedDate(\App\Models\BlockedDate $blockedDate)
    {
        if (!$blockedDate->google_event_id) {
            return $this->createBlockedDate($blockedDate);
        }

        try {
            $service = new Calendar($this->client);
            
            $event = $service->events->get($this->calendarId, $blockedDate->google_event_id);
            $event->setSummary("{$blockedDate->reason} - {$blockedDate->property->name}");
            $event->setDescription("Reason: {$blockedDate->reason}\nProperty: {$blockedDate->property->name}\nNotes: {$blockedDate->notes}\nCreated By: {$blockedDate->creator->name}");
            $event->setStart(new EventDateTime([
                'dateTime' => \Carbon\Carbon::parse($blockedDate->start_date)->startOfDay()->setTimezone('Asia/Kolkata')->toAtomString(),
                'timeZone' => 'Asia/Kolkata',
            ]));
            $event->setEnd(new EventDateTime([
                'dateTime' => \Carbon\Carbon::parse($blockedDate->end_date)->endOfDay()->setTimezone('Asia/Kolkata')->toAtomString(),
                'timeZone' => 'Asia/Kolkata',
            ]));
            $event->setColorId($this->getColorForReason($blockedDate->reason));

            $updatedEvent = $service->events->update($this->calendarId, $blockedDate->google_event_id, $event);

            return $updatedEvent;
        } catch (\Exception $e) {
            Log::error('Failed to update Google Calendar blocked date', [
                'blocked_date_id' => $blockedDate->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    private function getColorForReason($reason)
    {
        // Colors mapping to Google Calendar colorId
        // 11 = Red (Tomato)
        // 6  = Orange (Tangerine)
        // 9  = Blue (Blueberry)
        // 2  = Green (Sage)
        
        return match ($reason) {
            'Maintenance', 'Cleaning' => '11',
            'Owner Stay', 'Private Use' => '9',
            default => '11', // Default Red for blocks
        };
    }
}