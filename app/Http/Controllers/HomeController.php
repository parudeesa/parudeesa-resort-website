<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Booking;

class HomeController extends Controller
{
    public function index()
{
    $properties = \App\Models\Property::all(); // Fetches rooms from your DB
    return view('design', compact('properties')); // Sends them to design.blade.php
}

    public function show($id)
    {
        \Log::info('Property show method called', ['property_id' => $id]);
        $property = Property::with('amenities')->findOrFail($id);
        return view('property.show', compact('property'));
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
            'amount' => 'required|numeric'
        ]);

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
}
