<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Yacht;
use Illuminate\Support\Carbon;

class YachtController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|numeric|digits:10',
            'booking_date' => 'required|date|after_or_equal:today',
            'guests' => 'required|integer|min:1|max:15',
            'yacht_id' => 'required|exists:yachts,id',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $yacht = Yacht::findOrFail($request->yacht_id);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'check_in' => $request->booking_date,
            'check_out' => $request->booking_date, // Single day for yacht
            'guests' => $request->guests,
            'yacht_id' => $request->yacht_id,
            'type' => 'yacht',
            'amount' => $yacht->price,
            'status' => 'pending',
            'notes' => $request->special_requests,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Yacht booking received successfully!',
            'booking' => $booking
        ]);
    }

    public function index()
    {
        $yachts = Yacht::latest()->get();
        $bookings = Booking::where('type', 'yacht')->with('yacht')->latest()->get();
        return view('admin.yachts.index', compact('yachts', 'bookings'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|string',
            'capacity' => 'required|integer',
            'image_url' => 'required|url',
        ]);

        Yacht::create($request->all());

        return back()->with('success', 'Yacht added successfully.');
    }

    public function updateAdmin(Request $request, $id)
    {
        $yacht = Yacht::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration' => 'required|string',
            'capacity' => 'required|integer',
            'image_url' => 'required|url',
            'status' => 'required|boolean',
        ]);

        $yacht->update($request->all());

        return back()->with('success', 'Yacht updated successfully.');
    }

    public function destroyAdmin($id)
    {
        $yacht = Yacht::findOrFail($id);
        $yacht->delete();

        return back()->with('success', 'Yacht deleted successfully.');
    }
}
