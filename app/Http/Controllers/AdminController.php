<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function calendar()
    {
        $user = auth()->user();
        $query = \App\Models\Property::query();
        
        if ($user->role === 'admin') {
            $query->where('admin_id', $user->id);
        }
        
        $properties = $query->get();
        $propertyIds = $properties->pluck('id');
        
        $blockedDates = \App\Models\BlockedDate::with(['property', 'creator'])
            ->whereIn('property_id', $propertyIds)
            ->get()->map(function($item) {
            $item->is_block = true;
            $item->display_type = $item->reason;
            $item->display_name = 'Block: ' . $item->reason;
            return $item;
        });
        
        $manualReservations = \App\Models\Booking::with(['property', 'creator'])
            ->whereNotNull('created_by')
            ->whereIn('property_id', $propertyIds)
            ->get()->map(function($item) {
            $item->is_block = false;
            $item->display_type = 'Manual Reservation';
            $item->display_name = $item->name;
            $item->start_date = \Carbon\Carbon::parse($item->check_in);
            $item->end_date = \Carbon\Carbon::parse($item->check_out);
            return $item;
        });

        $events = $blockedDates->concat($manualReservations)->sortByDesc('created_at')->values();

        $amenities = \App\Models\Amenity::where('status', true)->get();
        $foodPackages = \App\Models\FoodPackage::where('status', true)->get();
        $bookingSettings = [
            'water_activity_threshold' => (int) \App\Models\Setting::get('water_activity_threshold', 5),
            'water_activity_low_price' => (float) \App\Models\Setting::get('water_activity_low_price', 1000),
            'water_activity_high_price' => (float) \App\Models\Setting::get('water_activity_high_price', 700),
            'property_stay_threshold' => (int) \App\Models\Setting::get('property_stay_threshold', 5),
        ];

        return view('admin.calendar', compact('properties', 'events', 'amenities', 'foodPackages', 'bookingSettings'));
    }

    // --- ADMIN MANAGEMENT (Superadmin only) ---
    public function adminsIndex()
    {
        $admins = \App\Models\User::where('role', 'admin')->latest()->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|string|alpha_dash|min:4|max:255|unique:users',
            'email' => 'nullable|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255',
            'name' => 'required|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'admin',
            'status' => 'active',
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin user created successfully.');
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = \App\Models\User::findOrFail($id);
        
        $request->validate([
            'username' => 'required|string|alpha_dash|min:4|max:255|unique:users,username,' . $id,
            'email' => 'nullable|email|max:255|unique:users,email,' . $id,
            'name' => 'required|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
            'password' => 'nullable|string|min:8|max:255',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $admin->update($data);

        return back()->with('success', 'Admin user updated successfully.');
    }

    public function destroyAdmin($id)
    {
        $admin = \App\Models\User::findOrFail($id);
        
        // Prevent deleting self
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $admin->delete();

        return back()->with('success', 'Admin user deleted successfully.');
    }

    public function toggleAdminStatus($id)
    {
        $admin = \App\Models\User::findOrFail($id);
        
        // Prevent deactivating self
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate yourself.');
        }

        $admin->status = ($admin->status === 'active') ? 'inactive' : 'active';
        $admin->save();

        return back()->with('success', 'Admin status updated successfully.');
    }

    // --- BLOCKED DATES ---

    public function storeBlock(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'reason' => 'required|string|min:3|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Authorization check for admin
        if (auth()->user()->role === 'admin') {
            $property = \App\Models\Property::find($request->property_id);
            if ($property->admin_id !== auth()->id()) {
                abort(403, 'Unauthorized access to this property.');
            }
        }

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

        // Authorization check for admin
        if (auth()->user()->role === 'admin') {
            if ($blockedDate->property->admin_id !== auth()->id()) {
                abort(403, 'Unauthorized access to this property.');
            }
        }

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
        
        // Authorization check for admin
        if (auth()->user()->role === 'admin') {
            if ($blockedDate->property->admin_id !== auth()->id()) {
                abort(403, 'Unauthorized access to this property.');
            }
        }

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
            'name' => 'required|string|min:3|max:255',
            'phone' => 'nullable|numeric|digits:10',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after_or_equal:check_in',
            'guests' => 'required|integer|min:1',
            'amount' => 'nullable|numeric|min:0',
            'package_name' => 'nullable|string',
            'payment_status' => 'required|string|in:Paid,Pending,Failed',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Authorization check for admin
        if (auth()->user()->role === 'admin') {
            $property = \App\Models\Property::find($request->property_id);
            if ($property->admin_id !== auth()->id()) {
                abort(403, 'Unauthorized access to this property.');
            }
        }

        // Format Amenities for quote
        $rawAmenities = $request->input('amenities', []);
        $processedAmenities = [];
        foreach ($rawAmenities as $id => $data) {
            if (!empty($data['selected']) && $data['selected'] == '1') {
                $processedAmenities[] = [
                    'id' => $id,
                    'quantity' => $data['participants'] ?? 1,
                ];
            }
        }
        
        $payload = $request->all();
        $payload['amenities'] = $processedAmenities;

        $pricingService = app(\App\Services\BookingPricingService::class);
        $quote = $pricingService->quote($payload);

        $booking = \App\Models\Booking::create([
            'property_id' => $request->property_id,
            'name' => $request->name,
            'email' => 'manual@reservation.local', // Dummy email for manual bookings
            'phone' => $request->phone,
            'check_in' => $quote['check_in'],
            'check_out' => $quote['check_out'],
            'guests' => $quote['guests'],
            'package_name' => $request->package_name ?? 'Only Stay',
            'amenities' => $quote['amenities'],
            'base_amount' => $quote['base_amount'],
            'amount' => filled($request->amount) ? $request->amount : $quote['amount'],
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
            'guests' => 'required|integer|min:1',
            'amount' => 'nullable|numeric',
            'package_name' => 'nullable|string',
            'payment_status' => 'required|string|in:Paid,Pending,Failed',
            'notes' => 'nullable|string'
        ]);

        // Authorization check for admin
        if (auth()->user()->role === 'admin') {
            if ($booking->property->admin_id !== auth()->id()) {
                abort(403, 'Unauthorized access to this property.');
            }
        }

        // Format Amenities for quote
        $rawAmenities = $request->input('amenities', []);
        $processedAmenities = [];
        foreach ($rawAmenities as $id => $data) {
            if (!empty($data['selected']) && $data['selected'] == '1') {
                $processedAmenities[] = [
                    'id' => $id,
                    'quantity' => $data['participants'] ?? 1,
                ];
            }
        }
        
        $payload = $request->all();
        $payload['amenities'] = $processedAmenities;

        $pricingService = app(\App\Services\BookingPricingService::class);
        $quote = $pricingService->quote($payload, $booking->id);

        $booking->update([
            'property_id' => $request->property_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'check_in' => $quote['check_in'],
            'check_out' => $quote['check_out'],
            'guests' => $quote['guests'],
            'package_name' => $request->package_name ?? 'Only Stay',
            'amenities' => $quote['amenities'],
            'base_amount' => $quote['base_amount'],
            'amount' => filled($request->amount) ? $request->amount : $quote['amount'],
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
        
        // Authorization check for admin
        if (auth()->user()->role === 'admin') {
            if ($booking->property->admin_id !== auth()->id()) {
                abort(403, 'Unauthorized access to this property.');
            }
        }

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
