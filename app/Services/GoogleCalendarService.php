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
        // Implementation for deleting event
    }
}