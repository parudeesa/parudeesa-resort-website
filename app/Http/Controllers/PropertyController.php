<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Property::with('amenities');
        
        if ($user->role === 'admin') {
            $query->where('admin_id', $user->id);
        }
        
        $properties = $query->paginate(10);
        $amenities = \App\Models\Amenity::where('status', true)->orderBy('name')->get();
        $admins = \App\Models\User::where('role', 'admin')->get();

        return view('properties.index', compact('properties', 'amenities', 'admins'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            abort(403, 'Admins cannot create properties.');
        }

        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10|max:5000',
            'weekday_price' => 'nullable|numeric|min:0',
            'weekday_tier2_price' => 'nullable|numeric|min:0',
            'weekend_price' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'type' => 'nullable|string|max:255',
            'location' => 'required|string|min:3|max:255',
            'phone' => 'nullable|numeric|digits:10',
            'admin_id' => 'nullable|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'highlights' => 'nullable|array',
            'highlights.*.label' => 'nullable|string|max:255',
            'highlights.*.icon' => 'nullable|string|max:80',
            'highlights.*.image' => 'nullable|string|max:255',
            'highlights.*.image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'accommodation' => 'nullable|array',
            'accommodation.*' => 'nullable|string|max:255',
            'outdoor_spaces' => 'nullable|array',
            'outdoor_spaces.*' => 'nullable|string|max:255',
        ]);

        $payload = $this->propertyPayload($request);
        $property = Property::create($payload);
        $property->amenities()->sync($request->input('amenities', []));

        return redirect()->route('properties.index')
            ->with('success', 'Property added successfully!');
    }

    public function update(Request $request, Property $property)
    {
        if (auth()->user()->role === 'admin' && $property->admin_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this property.');
        }

        $rules = [
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:10|max:5000',
            'weekday_price' => 'nullable|numeric|min:0',
            'weekday_tier2_price' => 'nullable|numeric|min:0',
            'weekend_price' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'type' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'location' => 'nullable|string|min:3|max:255',
            'phone' => 'nullable|numeric|digits:10',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'remove_gallery_images' => 'nullable|array',
            'highlights' => 'nullable|array',
            'highlights.*.label' => 'nullable|string|max:255',
            'highlights.*.icon' => 'nullable|string|max:80',
            'highlights.*.image' => 'nullable|string|max:255',
            'highlights.*.image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'accommodation' => 'nullable|array',
            'accommodation.*' => 'nullable|string|max:255',
            'outdoor_spaces' => 'nullable|array',
            'outdoor_spaces.*' => 'nullable|string|max:255',
        ];

        if (auth()->user()->isSuperAdmin()) {
            $rules['admin_id'] = 'nullable|exists:users,id';
        }

        $request->validate($rules);

        $payload = $this->propertyPayload($request, $property);
        $property->update($payload);
        $property->amenities()->sync($request->input('amenities', []));

        return redirect()->route('properties.index')
            ->with('success', 'Property updated successfully!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role === 'admin') {
            abort(403, 'Admins cannot delete properties.');
        }

        $property = Property::findOrFail($id);
        
        // Delete images
        if ($property->image && File::exists(public_path($property->image))) {
            File::delete(public_path($property->image));
        }
        
        if ($property->gallery_images) {
            foreach ($property->gallery_images as $img) {
                if (File::exists(public_path($img))) {
                    File::delete(public_path($img));
                }
            }
        }

        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully!');
    }

    private function propertyPayload(Request $request, ?Property $property = null): array
    {
        $highlightsData = $request->input('highlights', []);
        $highlightFiles = $request->file('highlights', []);

        $highlights = collect($highlightsData)
            ->map(function ($item, $index) use ($highlightFiles, $property) {
                $label = trim($item['label'] ?? '');
                if ($label === '') return null;

                $imagePath = $item['image'] ?? '';

                // Handle file upload for this highlight
                if (isset($highlightFiles[$index]['image_file'])) {
                    $file = $highlightFiles[$index]['image_file'];
                    
                    // Delete old highlight image if it exists
                    if ($imagePath && !str_starts_with($imagePath, 'http') && File::exists(public_path($imagePath))) {
                        File::delete(public_path($imagePath));
                    }

                    $filename = time() . '_hl_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                    if (!File::exists(public_path('images/properties/highlights'))) {
                        File::makeDirectory(public_path('images/properties/highlights'), 0755, true);
                    }
                    $file->move(public_path('images/properties/highlights'), $filename);
                    $imagePath = 'images/properties/highlights/' . $filename;
                }

                return [
                    'label' => $label,
                    'icon' => trim($item['icon'] ?? ''),
                    'image' => $imagePath,
                ];
            })
            ->filter()
            ->values()
            ->all();

        $payload = [
            'name' => $request->name,
            'description' => $request->description,
            'weekday_price' => $request->weekday_price,
            'weekday_tier2_price' => $request->weekday_tier2_price,
            'weekend_price' => $request->weekend_price,
            'capacity' => $request->capacity,
            'status' => $request->has('status') ? (bool)$request->status : true,
            'type' => $request->type,
            'location' => $request->location,
            'phone' => $request->phone,
            'highlights' => $highlights,
            'accommodation' => array_values(array_filter($request->input('accommodation', []), fn($val) => !empty(trim($val)))),
            'outdoor_spaces' => array_values(array_filter($request->input('outdoor_spaces', []), fn($val) => !empty(trim($val)))),
        ];

        if ($request->has('admin_id') && auth()->user()->isSuperAdmin()) {
            $payload['admin_id'] = $request->admin_id;
        }

        // Handle Main Image Upload
        if ($request->hasFile('image')) {
            // Delete old image if updating
            if ($property && $property->image && File::exists(public_path($property->image))) {
                File::delete(public_path($property->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $path = 'images/properties/' . $filename;
            
            if (!File::exists(public_path('images/properties'))) {
                File::makeDirectory(public_path('images/properties'), 0755, true);
            }
            
            $file->move(public_path('images/properties'), $filename);
            $payload['image'] = $path;
        }

        // Handle Gallery Images Upload
        $currentGallery = $property ? ($property->gallery_images ?? []) : [];
        
        // Remove selected gallery images
        if ($request->has('remove_gallery_images')) {
            foreach ($request->remove_gallery_images as $imgToRemove) {
                if (File::exists(public_path($imgToRemove))) {
                    File::delete(public_path($imgToRemove));
                }
                $currentGallery = array_filter($currentGallery, fn($img) => $img !== $imgToRemove);
            }
            $currentGallery = array_values($currentGallery);
        }

        if ($request->hasFile('gallery_images')) {
            if (!File::exists(public_path('images/properties'))) {
                File::makeDirectory(public_path('images/properties'), 0755, true);
            }

            foreach ($request->file('gallery_images') as $file) {
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $path = 'images/properties/' . $filename;
                $file->move(public_path('images/properties'), $filename);
                $currentGallery[] = $path;
            }
        }
        
        $payload['gallery_images'] = $currentGallery;

        return $payload;
    }
}
