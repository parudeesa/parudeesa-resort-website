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
        $properties = Property::with('amenities')->get(); // Fetches rooms from your DB
        //dd($properties);
        return view('design', compact('properties')); // Sends them to design.blade.php
    }
    public function home()
    {
        return view('home');    
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
            'user_id' => auth()->id(), // Link to logged-in user if available
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
    public function bookingsIndex()
    {
        $user = auth()->user();
        $query = Booking::with('property');

        if ($user->role === 'admin') {
            $query->whereHas('property', function($q) use ($user) {
                $q->where('admin_id', $user->id);
            });
        } elseif ($user->role === 'customer') {
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('phone', $user->phone);
            });
        }

        if ($user->isCustomer()) {
            $all = $query->latest()->get();
            $upcomingBookings = $all->filter(function($b) {
                $checkOut = Carbon::parse($b->check_out)->startOfDay();
                $today = Carbon::today();
                return $checkOut->gte($today);
            });
            $pastBookings = $all->filter(function($b) {
                $checkOut = Carbon::parse($b->check_out)->startOfDay();
                $today = Carbon::today();
                return $checkOut->lt($today);
            });
            return view('bookings.index', compact('upcomingBookings', 'pastBookings'));
        }

        $bookings = $query->latest()->paginate(10);
        return view('bookings.index', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $user = auth()->user();
        
        // Authorization check
        if ($user->role === 'admin') {
            if (!$booking->property || $booking->property->admin_id !== $user->id) {
                abort(403, 'Unauthorized to manage this booking.');
            }
        } elseif ($user->role !== 'superadmin' && !$user->is_super_admin) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|string|in:confirmed,pending,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking status updated to ' . $request->status . ' successfully.');
    }

    public function checkPhoneBookings($phone)
    {
        $exists = \App\Models\Booking::where('phone', $phone)->exists();
        return response()->json(['exists' => $exists]);
    }
}
