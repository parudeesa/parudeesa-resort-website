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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'pricing_type' => 'nullable|in:fixed,per_person',
            'status' => 'nullable|boolean'
        ]);

        Amenity::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price ?? 0,
            'pricing_type' => $request->pricing_type ?? 'fixed',
            'status' => $request->has('status') ? (bool)$request->status : true
        ]);

        return redirect()->back()->with('success', 'Amenity added successfully!');
    }

    public function update(Request $request, Amenity $amenity)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'pricing_type' => 'nullable|in:fixed,per_person',
            'status' => 'nullable|boolean'
        ]);

        $amenity->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price ?? $amenity->price ?? 0,
            'pricing_type' => $request->pricing_type ?? $amenity->pricing_type ?? 'fixed',
            'status' => $request->has('status') ? (bool)$request->status : $amenity->status
        ]);

        return redirect()->back()->with('success', 'Amenity updated successfully!');
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();

        return redirect()->back()->with('success', 'Amenity deleted successfully!');
    }
}
