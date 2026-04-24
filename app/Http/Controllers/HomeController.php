<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class HomeController extends Controller
{
    public function index()
{
    $properties = \App\Models\Property::all(); // Fetches rooms from your DB
    return view('design', compact('properties')); // Sends them to design.blade.php
}

    public function storeBooking(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'room_type' => 'required|string|max:255',
        ]);

        $booking = \App\Models\Booking::create([
            'name' => $request->name,
            'email' => $request->email,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'room_type' => $request->room_type,
            'guests' => 2, // Default value since it is required in DB schema
            'amount' => 0.00, // Quote to be decided
            'status' => 'pending',
            'phone' => '' // Can be updated via whatsapp link integration implicitly
        ]);

        return response()->json(['success' => true, 'booking' => $booking]);
    }
}
