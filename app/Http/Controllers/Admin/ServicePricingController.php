<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventService;
use App\Models\FoodPackage;
use Illuminate\Http\Request;

class ServicePricingController extends Controller
{
    public function index()
    {
        $foodPackages = FoodPackage::all();
        $eventServices = EventService::all();
        return view('admin.pricing.index', compact('foodPackages', 'eventServices'));
    }

    // Food Packages
    public function storeFood(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        FoodPackage::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->has('status') ? $request->status : true,
        ]);

        return back()->with('success', 'Food package added.');
    }

    public function updateFood(Request $request, $id)
    {
        $package = FoodPackage::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $package->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->has('status') ? (bool)$request->status : $package->status,
        ]);

        return back()->with('success', 'Food package updated.');
    }

    public function destroyFood($id)
    {
        FoodPackage::findOrFail($id)->delete();
        return back()->with('success', 'Food package deleted.');
    }

    // Event Services
    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'icon' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        EventService::create([
            'name' => $request->name,
            'price' => $request->price,
            'icon' => $request->icon,
            'description' => $request->description,
            'status' => $request->has('status') ? $request->status : true,
        ]);

        return back()->with('success', 'Event service added.');
    }

    public function updateService(Request $request, $id)
    {
        $service = EventService::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'icon' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $service->update([
            'name' => $request->name,
            'price' => $request->price,
            'icon' => $request->icon,
            'description' => $request->description,
            'status' => $request->has('status') ? (bool)$request->status : $service->status,
        ]);

        return back()->with('success', 'Event service updated.');
    }

    public function destroyService($id)
    {
        EventService::findOrFail($id)->delete();
        return back()->with('success', 'Event service deleted.');
    }

    public function amenitiesIndex()
    {
        $amenities = \App\Models\Amenity::orderBy('name')->get();
        $settings = [
            'water_activity_threshold' => \App\Models\Setting::get('water_activity_threshold', 5),
            'water_activity_low_price' => \App\Models\Setting::get('water_activity_low_price', 1000),
            'water_activity_high_price' => \App\Models\Setting::get('water_activity_high_price', 700),
            'property_stay_threshold' => \App\Models\Setting::get('property_stay_threshold', 5),
            'sheesha_capacity' => \App\Models\Setting::get('sheesha_capacity', 6),
        ];
        return view('admin.pricing.amenities', compact('amenities', 'settings'));
    }

    public function updateAmenitiesPricing(Request $request)
    {
        // Update individual amenity prices
        if ($request->has('amenities')) {
            foreach ($request->amenities as $id => $data) {
                $amenity = \App\Models\Amenity::find($id);
                if ($amenity) {
                    $amenity->update([
                        'price' => $data['price'],
                        'pricing_type' => $data['pricing_type'] ?? $amenity->pricing_type,
                    ]);
                }
            }
        }

        // Update tiered pricing settings
        if ($request->has('settings')) {
            foreach ($request->settings as $key => $value) {
                \App\Models\Setting::set($key, $value);
            }
        }

        return back()->with('success', 'Amenity pricing rules updated successfully.');
    }
}
