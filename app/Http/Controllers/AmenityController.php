<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::all();
        return view('amenities.index', compact('amenities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'nullable|numeric|min:0|max:100000',
            'pricing_type' => 'required|in:fixed,per_person',
            'status' => 'nullable|boolean'
        ]);

        Amenity::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price ?? 0,
            'pricing_type' => $request->pricing_type ?? 'fixed',
            'status' => $request->has('status') ? (bool)$request->status : true,
            'is_premium' => $request->has('is_premium') ? (bool)$request->is_premium : false,
            'image_url' => $request->image_url,
            'condition_note' => $request->condition_note
        ]);

        return redirect()->back()->with('success', 'Amenity added successfully!');
    }

    public function update(Request $request, Amenity $amenity)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'nullable|numeric|min:0|max:100000',
            'pricing_type' => 'required|in:fixed,per_person',
            'status' => 'nullable|boolean'
        ]);

        $amenity->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price ?? $amenity->price ?? 0,
            'pricing_type' => $request->pricing_type ?? $amenity->pricing_type ?? 'fixed',
            'status' => $request->has('status') ? (bool)$request->status : $amenity->status,
            'is_premium' => $request->has('is_premium') ? (bool)$request->is_premium : $amenity->is_premium,
            'image_url' => $request->image_url ?? $amenity->image_url,
            'condition_note' => $request->condition_note ?? $amenity->condition_note
        ]);

        return redirect()->back()->with('success', 'Amenity updated successfully!');
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();

        return redirect()->back()->with('success', 'Amenity deleted successfully!');
    }
}
