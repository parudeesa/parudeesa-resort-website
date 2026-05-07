<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'admin_id' => 'nullable|exists:users,id',
            'image_url' => 'nullable|url',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'nullable|url',
            'highlights' => 'nullable|array',
            'highlights.*.label' => 'nullable|string|max:255',
            'highlights.*.icon' => 'nullable|string|max:80',
            'highlights.*.image' => 'nullable|url',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        $property = Property::create($this->propertyPayload($request));
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'image_url' => 'nullable|url',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'nullable|url',
            'highlights' => 'nullable|array',
            'highlights.*.label' => 'nullable|string|max:255',
            'highlights.*.icon' => 'nullable|string|max:80',
            'highlights.*.image' => 'nullable|url',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ];

        if (auth()->user()->isSuperAdmin()) {
            $rules['admin_id'] = 'nullable|exists:users,id';
        }

        $request->validate($rules);

        $property->update($this->propertyPayload($request));
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
        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully!');
    }

    private function propertyPayload(Request $request): array
    {
        $highlights = collect($request->input('highlights', []))
            ->map(fn ($item) => [
                'label' => trim($item['label'] ?? ''),
                'icon' => trim($item['icon'] ?? ''),
                'image' => trim($item['image'] ?? ''),
            ])
            ->filter(fn ($item) => $item['label'] !== '')
            ->values()
            ->all();

        $galleryImages = collect($request->input('gallery_images', []))
            ->filter()
            ->values()
            ->all();

        $payload = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'location' => $request->location,
            'phone' => $request->phone,
            'image_url' => $request->image_url,
            'gallery_images' => $galleryImages,
            'highlights' => $highlights,
        ];

        if ($request->has('admin_id') && auth()->user()->isSuperAdmin()) {
            $payload['admin_id'] = $request->admin_id;
        }

        return $payload;
    }
}
