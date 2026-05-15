<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'property_assignment' => 'required|in:paradise,utopia,both',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price ?? 0,
            'pricing_type' => $request->pricing_type ?? 'fixed',
            'status' => $request->has('status') ? (bool)$request->status : true,
            'is_premium' => $request->has('is_premium') ? (bool)$request->is_premium : false,
            'condition_note' => $request->condition_note,
            'property_assignment' => $request->property_assignment ?? 'both',
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $path = 'images/amenities/' . $filename;
            
            if (!File::exists(public_path('images/amenities'))) {
                File::makeDirectory(public_path('images/amenities'), 0755, true);
            }
            
            $file->move(public_path('images/amenities'), $filename);
            $data['image'] = $path;
        }

        Amenity::create($data);

        return redirect()->back()->with('success', 'Amenity added successfully!');
    }

    public function update(Request $request, Amenity $amenity)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'nullable|numeric|min:0|max:100000',
            'pricing_type' => 'required|in:fixed,per_person',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'property_assignment' => 'required|in:paradise,utopia,both',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price ?? $amenity->price ?? 0,
            'pricing_type' => $request->pricing_type ?? $amenity->pricing_type ?? 'fixed',
            'status' => $request->has('status') ? (bool)$request->status : $amenity->status,
            'is_premium' => $request->has('is_premium') ? (bool)$request->is_premium : $amenity->is_premium,
            'condition_note' => $request->condition_note ?? $amenity->condition_note,
            'property_assignment' => $request->property_assignment ?? $amenity->property_assignment ?? 'both',
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($amenity->image && File::exists(public_path($amenity->image))) {
                File::delete(public_path($amenity->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $path = 'images/amenities/' . $filename;
            
            if (!File::exists(public_path('images/amenities'))) {
                File::makeDirectory(public_path('images/amenities'), 0755, true);
            }
            
            $file->move(public_path('images/amenities'), $filename);
            $data['image'] = $path;
        }

        $amenity->update($data);

        return redirect()->back()->with('success', 'Amenity updated successfully!');
    }

    public function destroy(Amenity $amenity)
    {
        if ($amenity->image && File::exists(public_path($amenity->image))) {
            File::delete(public_path($amenity->image));
        }

        $amenity->delete();

        return redirect()->back()->with('success', 'Amenity deleted successfully!');
    }
}
