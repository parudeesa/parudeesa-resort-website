<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::paginate(10);
        return view('property.index', compact('properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'image_url' => 'nullable|url',
        ]);

        Property::create($request->all());

        return redirect()->back()->with('success', 'Property added successfully');
    }

    public function destroy($id)
    {
        Property::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Property deleted successfully');
    }
}