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
            'price' => 'required|numeric|min:0',
            'pricing_type' => 'required|in:per_person,fixed',
            'status' => 'sometimes|boolean',
        ]);

        Amenity::create($request->only(['name', 'description', 'price', 'pricing_type', 'status']));

        return redirect()->back()->with('success', 'Amenity added successfully!');
    }

    public function update(Request $request, Amenity $amenity)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'pricing_type' => 'required|in:per_person,fixed',
            'status' => 'sometimes|boolean',
        ]);

        $amenity->update($request->only(['name', 'description', 'price', 'pricing_type', 'status']));

        return redirect()->back()->with('success', 'Amenity updated successfully!');
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();

        return redirect()->back()->with('success', 'Amenity deleted successfully!');
    }
}
