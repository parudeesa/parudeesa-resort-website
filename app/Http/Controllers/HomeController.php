<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Property;
use App\Models\Booking;
use App\Models\BlockedDate;
use App\Models\Amenity;

class HomeController extends Controller
{
    public function index()
{
    $properties = \App\Models\Property::all(); // Fetches rooms from your DB
    return view('design', compact('properties')); // Sends them to design.blade.php
}

    public function design()
    {
        $properties = Property::with('amenities')->get();
        return view('design', compact('properties'));
    }

    public function show($id)
    {
        \Log::info('Property show method called', ['property_id' => $id]);
        $property = Property::with('amenities')->findOrFail($id);
        $amenities = Amenity::where('status', true)->orderBy('name')->get();

        return view('properties.show', compact('property', 'amenities'));
    }

    public function unavailableDates($id)
    {
        $property = Property::findOrFail($id);

        $bookings = Booking::where('property_id', $property->id)
            ->where(function ($query) {
                $query->whereNull('status')
                      ->orWhere('status', '!=', 'cancelled');
            })
            ->get();

        $blockedDates = BlockedDate::where('property_id', $property->id)->get();

        $disabled = [];

        foreach ($blockedDates as $blockedDate) {
            $current = Carbon::parse($blockedDate->start_date);
            $end = Carbon::parse($blockedDate->end_date);

            while ($current->lte($end)) {
                $disabled[] = $current->format('Y-m-d');
                $current->addDay();
            }
        }

        foreach ($bookings as $booking) {
            if (! $booking->check_in || ! $booking->check_out) {
                continue;
            }

            $current = Carbon::parse($booking->check_in);
            $end = Carbon::parse($booking->check_out);

            while ($current->lte($end)) {
                $disabled[] = $current->format('Y-m-d');
                $current->addDay();
            }
        }

        $disabled = array_values(array_unique($disabled));
        sort($disabled);

        return response()->json($disabled);
    }

    public function bookingsIndex()
    {
        $bookings = Booking::with('property')->latest()->paginate(15);
        return view('bookings.index', compact('bookings'));
    }

    public function unavailableDates($propertyId)
    {
        $bookings = Booking::where('property_id', $propertyId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(['check_in', 'check_out']);

        $blocks = \App\Models\BlockedDate::where('property_id', $propertyId)
            ->get(['start_date', 'end_date']);

        $dateRanges = [];

        foreach ($bookings as $booking) {
            $dateRanges[] = [
                'from' => $booking->check_in->toDateString(),
                'to'   => $booking->check_out->toDateString(),
            ];
        }

        foreach ($blocks as $block) {
            $dateRanges[] = [
                'from' => $block->start_date->toDateString(),
                'to'   => $block->end_date->toDateString(),
            ];
        }

        return response()->json($dateRanges);
    }

   

    public function storeBooking(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'guests' => 'required|integer|min:1',
            'property_id' => 'required|exists:properties,id',
            'event_type' => 'nullable|string|max:255',
            'package_name' => 'nullable|string|max:255',
            'amenities' => 'nullable|array',
            'base_amount' => 'required|numeric',
            'extra_amount' => 'required|numeric',
            'amount' => 'required|numeric'
        ]);

        $checkIn = \Carbon\Carbon::parse($request->check_in)->startOfDay();
        $checkOut = \Carbon\Carbon::parse($request->check_out)->endOfDay();

        // Check availability in Bookings
        $hasBookingConflict = Booking::where('property_id', $request->property_id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out', [$checkIn, $checkOut])
                      ->orWhere(function($q) use ($checkIn, $checkOut) {
                          $q->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                      });
            })->exists();

        if ($hasBookingConflict) {
            return response()->json([
                'success' => false,
                'message' => 'The selected dates are already booked. Please choose different dates.'
            ], 422);
        }

        // Check availability in Blocked Dates
        $hasBlockedDateConflict = \App\Models\BlockedDate::where('property_id', $request->property_id)
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->whereBetween('start_date', [$checkIn, $checkOut])
                      ->orWhereBetween('end_date', [$checkIn, $checkOut])
                      ->orWhere(function($q) use ($checkIn, $checkOut) {
                          $q->where('start_date', '<=', $checkIn)
                            ->where('end_date', '>=', $checkOut);
                      });
            })->exists();

        if ($hasBlockedDateConflict) {
            return response()->json([
                'success' => false,
                'message' => 'The selected dates are unavailable. Please choose different dates.'
            ], 422);
        }

        $booking = Booking::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guests' => $request->guests,
            'property_id' => $request->property_id,
            'event_type' => $request->event_type,
            'package_name' => $request->package_name,
            'amenities' => $request->amenities,
            'base_price' => $request->base_amount,
            'amenities_total' => $request->extra_amount,
            'grand_total' => $request->amount,
            'selected_amenities_json' => $request->amenities,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        // Load property for calendar event
        $booking->load('property');

        // Sync to Google Calendar
        $calendarService = app(\App\Services\GoogleCalendarService::class);
        $calendarSynced = $calendarService->createEvent($booking);

        return response()->json([
            'success' => true,
            'booking' => $booking,
            'calendar_synced' => $calendarSynced !== false
        ]);
    }
    public function bookingsIndex()
{
    $bookings = Booking::with('property')->latest()->paginate(10);
    return view('bookings.index', compact('bookings'));
}
}
