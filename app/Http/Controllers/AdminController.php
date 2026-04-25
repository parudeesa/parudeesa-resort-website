<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function calendar()
    {
        $properties = \App\Models\Property::all();
        
        $blockedDates = \App\Models\BlockedDate::with(['property', 'creator'])->get()->map(function($item) {
            $item->is_block = true;
            $item->display_type = $item->reason;
            $item->display_name = 'Block: ' . $item->reason;
            return $item;
        });
        
        $manualReservations = \App\Models\Booking::with(['property', 'creator'])->whereNotNull('created_by')->get()->map(function($item) {
            $item->is_block = false;
            $item->display_type = 'Manual Reservation';
            $item->display_name = $item->name;
            $item->start_date = \Carbon\Carbon::parse($item->check_in);
            $item->end_date = \Carbon\Carbon::parse($item->check_out);
            return $item;
        });

        $events = $blockedDates->concat($manualReservations)->sortByDesc('created_at')->values();

        return view('admin.calendar', compact('properties', 'events'));
    }

    // --- BLOCKED DATES ---

    public function storeBlock(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'reason' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string'
        ]);

        $blockedDate = \App\Models\BlockedDate::create([
            'property_id' => $request->property_id,
            'reason' => $request->reason,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'notes' => $request->notes,
            'created_by' => auth()->id()
        ]);

        $blockedDate->load(['property', 'creator']);

        $calendarService = app(\App\Services\GoogleCalendarService::class);
        $googleEvent = $calendarService->createBlockedDate($blockedDate);
        
        if ($googleEvent) {
            $blockedDate->update(['google_event_id' => $googleEvent->id]);
        }

        return back()->with('success', 'Dates blocked successfully and synced to calendar.');
    }

    public function updateBlock(Request $request, $id)
    {
        $blockedDate = \App\Models\BlockedDate::findOrFail($id);

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'reason' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string'
        ]);

        $blockedDate->update([
            'property_id' => $request->property_id,
            'reason' => $request->reason,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'notes' => $request->notes
        ]);

        $blockedDate->load(['property', 'creator']);

        $calendarService = app(\App\Services\GoogleCalendarService::class);
        $calendarService->updateBlockedDate($blockedDate);

        return back()->with('success', 'Blocked dates updated successfully.');
    }

    public function destroyBlock($id)
    {
        $blockedDate = \App\Models\BlockedDate::findOrFail($id);
        
        if ($blockedDate->google_event_id) {
            $calendarService = app(\App\Services\GoogleCalendarService::class);
            $calendarService->deleteEvent($blockedDate->google_event_id);
        }

        $blockedDate->delete();

        return back()->with('success', 'Blocked dates removed successfully.');
    }

    // --- MANUAL RESERVATIONS ---

    public function storeReservation(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
            'amount' => 'nullable|numeric',
            'payment_status' => 'required|string|in:Paid,Pending',
            'notes' => 'nullable|string'
        ]);

        $booking = \App\Models\Booking::create([
            'property_id' => $request->property_id,
            'name' => $request->name,
            'email' => 'manual@reservation.local', // Dummy email for manual bookings
            'phone' => $request->phone,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guests' => 1,
            'amount' => $request->amount ?? 0,
            'status' => $request->payment_status === 'Paid' ? 'confirmed' : 'pending',
            'payment_status' => $request->payment_status,
            'notes' => $request->notes,
            'created_by' => auth()->id()
        ]);

        $booking->load(['property']);

        $calendarService = app(\App\Services\GoogleCalendarService::class);
        $googleEvent = $calendarService->createEvent($booking);
        
        if ($googleEvent) {
            $booking->update(['google_event_id' => $googleEvent->id]);
        }

        return back()->with('success', 'Manual reservation added and synced to calendar.');
    }

    public function updateReservation(Request $request, $id)
    {
        $booking = \App\Models\Booking::findOrFail($id);

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
            'amount' => 'nullable|numeric',
            'payment_status' => 'required|string|in:Paid,Pending',
            'notes' => 'nullable|string'
        ]);

        $booking->update([
            'property_id' => $request->property_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'amount' => $request->amount ?? 0,
            'status' => $request->payment_status === 'Paid' ? 'confirmed' : 'pending',
            'payment_status' => $request->payment_status,
            'notes' => $request->notes
        ]);

        $booking->load(['property']);

        // Since createEvent might act as update if we modify it or we can just ignore update sync for now if not implemented.
        // Wait, the GoogleCalendarService doesn't have updateEvent fully implemented for bookings yet.
        // We'll leave it as is or add a simple delete and recreate if we want.
        if ($booking->google_event_id) {
            $calendarService = app(\App\Services\GoogleCalendarService::class);
            $calendarService->deleteEvent($booking->google_event_id);
            $googleEvent = $calendarService->createEvent($booking);
            if ($googleEvent) {
                $booking->update(['google_event_id' => $googleEvent->id]);
            }
        }

        return back()->with('success', 'Manual reservation updated successfully.');
    }

    public function destroyReservation($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        
        if ($booking->google_event_id) {
            $calendarService = app(\App\Services\GoogleCalendarService::class);
            $calendarService->deleteEvent($booking->google_event_id);
        }

        $booking->delete();

        return back()->with('success', 'Manual reservation deleted successfully.');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
