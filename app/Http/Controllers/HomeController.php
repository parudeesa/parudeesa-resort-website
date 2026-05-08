<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Property;
use App\Models\Booking;
use App\Models\BlockedDate;
use App\Models\Amenity;
use App\Models\Yacht;
use App\Services\BookingPricingService;

class HomeController extends Controller
{
    public function __construct(protected BookingPricingService $pricingService) {}

    public function index()
    {
        $properties = Property::with('amenities')->get();
        $yachts = Yacht::where('status', true)->get();
        return view('design', compact('properties', 'yachts'));
    }
    public function home()
    {
        return view('home');    
    }

    public function design()
    {
        $properties = Property::with('amenities')->get();
        $yachts = Yacht::where('status', true)->get();
        return view('design', compact('properties', 'yachts'));
    }

    public function show($id)
    {
        \Log::info('Property show method called', ['property_id' => $id]);
        $property = Property::with('amenities')->findOrFail($id);
        $amenities = Amenity::where('status', true)->orderBy('name')->get();
        $activeCoupons = \App\Models\Coupon::where('is_active', true)->get();

        return view('properties.show', compact('property', 'amenities', 'activeCoupons'));
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
            'name' => 'required|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|numeric|digits:10',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:50',
            'property_id' => 'required|exists:properties,id',
            'event_type' => 'nullable|string|max:255',
            'package_name' => 'nullable|string|max:255',
            'amenities' => 'nullable|array',
            'amount' => 'required|numeric',
            'coupon_id' => 'nullable|exists:coupons,id',
            'discount_amount' => 'nullable|numeric',
            'pets' => 'nullable|integer|min:0'
        ]);

        $quote = $this->pricingService->quote($request->all());

        $notes = $request->notes;
        if ($request->pets > 0) {
            $notes = ($notes ? $notes . "\n" : "") . "Pets: " . $request->pets;
        }

        $booking = Booking::create([
            'user_id' => auth()->id(), // Link to logged-in user if available
            'name' => $request->name,
            'phone' => $request->phone,
            'check_in' => $quote['check_in'],
            'check_out' => $quote['check_out'],
            'guests' => $quote['guests'],
            'property_id' => $quote['property']['id'],
            'event_type' => $request->event_type,
            'package_name' => $request->package_name,
            'amenities' => $quote['amenities'],
            'base_amount' => $quote['base_amount'],
            'amount' => $quote['amount'],
            'coupon_id' => $quote['coupon_id'],
            'discount_amount' => $quote['discount_amount'],
            'notes' => $notes,
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
        $query = Booking::with(['property', 'yacht']);

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
