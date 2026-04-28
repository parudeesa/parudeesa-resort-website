<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::paginate(10);
        return view('properties.index', compact('properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'image_url' => 'nullable|url',
        ]);

        Property::create($request->all());

        return redirect()->route('properties.index')
            ->with('success', 'Property added successfully!');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully!');
    }
}