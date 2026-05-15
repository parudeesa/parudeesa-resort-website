<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventAmenity;
use App\Models\EventCard;
use App\Models\EventGallery;
use App\Models\EventPricingFeature;
use App\Models\EventStep;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventPageController extends Controller
{
    public function index()
    {
        $hero = json_decode(Setting::get('events_hero', '{}'), true);
        $pricing = json_decode(Setting::get('events_pricing', '{}'), true);
        $seo = json_decode(Setting::get('events_seo', '{}'), true);
        $theme = json_decode(Setting::get('events_theme', '{}'), true);
        
        $cards = EventCard::orderBy('order')->get();
        $amenities = EventAmenity::orderBy('order')->get();
        $gallery = EventGallery::orderBy('order')->get();
        $steps = EventStep::orderBy('order')->get();
        $pricingFeatures = EventPricingFeature::orderBy('order')->get();

        return view('admin.events.manager', compact(
            'hero', 'pricing', 'seo', 'theme', 'cards', 'amenities', 'gallery', 'steps', 'pricingFeatures'
        ));
    }

    public function updateHero(Request $request)
    {
        $data = $request->only(['eyebrow', 'title', 'subtitle', 'cta_1_text', 'cta_1_link', 'cta_2_text', 'cta_2_link']);
        $data['status'] = $request->has('status');
        
        $current = json_decode(Setting::get('events_hero', '{}'), true);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $data['image'] = Storage::url($path);
        } else {
            $data['image'] = $current['image'] ?? '';
        }

        Setting::updateOrCreate(
            ['key' => 'events_hero', 'group' => 'events_page'],
            ['value' => json_encode($data), 'type' => 'json']
        );

        return back()->with('success', 'Hero section updated successfully.');
    }

    public function updatePricingSettings(Request $request)
    {
        $data = $request->only(['label', 'title', 'subtitle', 'cta_text', 'badge_label', 'badge_value']);
        $data['status'] = $request->has('status');
        
        $current = json_decode(Setting::get('events_pricing', '{}'), true);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $data['image'] = Storage::url($path);
        } else {
            $data['image'] = $current['image'] ?? '';
        }

        Setting::updateOrCreate(
            ['key' => 'events_pricing', 'group' => 'events_page'],
            ['value' => json_encode($data), 'type' => 'json']
        );

        return back()->with('success', 'Pricing settings updated successfully.');
    }

    public function updateSEO(Request $request)
    {
        $data = $request->only(['title', 'description', 'schema_markup']);
        
        $current = json_decode(Setting::get('events_seo', '{}'), true);
        
        if ($request->hasFile('og_image')) {
            $path = $request->file('og_image')->store('events', 'public');
            $data['og_image'] = Storage::url($path);
        } else {
            $data['og_image'] = $current['og_image'] ?? '';
        }

        Setting::updateOrCreate(
            ['key' => 'events_seo', 'group' => 'events_page'],
            ['value' => json_encode($data), 'type' => 'json']
        );

        return back()->with('success', 'SEO settings updated successfully.');
    }

    // CRUD for Event Cards
    public function storeCard(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'icon' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = Storage::url($request->file('image')->store('events', 'public'));
        }

        EventCard::create($data);
        return back()->with('success', 'Event card added.');
    }

    public function updateCard(Request $request, EventCard $card)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = Storage::url($request->file('image')->store('events', 'public'));
        }

        $card->update($data);
        return back()->with('success', 'Event card updated.');
    }

    public function deleteCard(EventCard $card)
    {
        $card->delete();
        return back()->with('success', 'Event card deleted.');
    }

    // Add similar methods for Amenities, Gallery, Steps, PricingFeatures...
    // For brevity, I'll combine sorting into one method
    
    // CRUD for Amenities
    public function storeAmenity(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = Storage::url($request->file('image')->store('events', 'public'));
        }

        EventAmenity::create($data);
        return back()->with('success', 'Amenity added.');
    }

    public function updateAmenity(Request $request, EventAmenity $amenity)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = Storage::url($request->file('image')->store('events', 'public'));
        }

        $amenity->update($data);
        return back()->with('success', 'Amenity updated.');
    }

    public function deleteAmenity(EventAmenity $amenity)
    {
        $amenity->delete();
        return back()->with('success', 'Amenity deleted.');
    }

    // CRUD for Gallery
    public function storeGallery(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image',
            'category' => 'nullable|string',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('events', 'public');
                EventGallery::create([
                    'image' => Storage::url($path),
                    'category' => $request->category,
                    'status' => true
                ]);
            }
        }

        return back()->with('success', 'Gallery images uploaded.');
    }

    public function deleteGallery(EventGallery $gallery)
    {
        $gallery->delete();
        return back()->with('success', 'Gallery image deleted.');
    }

    // CRUD for Steps
    public function storeStep(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'step_number' => 'nullable|integer',
        ]);

        EventStep::create($data);
        return back()->with('success', 'Step added.');
    }

    public function updateStep(Request $request, EventStep $step)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'step_number' => 'nullable|integer',
        ]);

        $step->update($data);
        return back()->with('success', 'Step updated.');
    }

    public function deleteStep(EventStep $step)
    {
        $step->delete();
        return back()->with('success', 'Step deleted.');
    }

    // CRUD for Pricing Features
    public function storeFeature(Request $request)
    {
        $data = $request->validate([
            'text' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        EventPricingFeature::create($data);
        return back()->with('success', 'Feature added.');
    }

    public function deleteFeature(EventPricingFeature $feature)
    {
        $feature->delete();
        return back()->with('success', 'Feature deleted.');
    }

    public function updateOrder(Request $request)
    {
        $type = $request->type;
        $ids = $request->ids;

        $model = match($type) {
            'card' => EventCard::class,
            'amenity' => EventAmenity::class,
            'gallery' => EventGallery::class,
            'step' => EventStep::class,
            'feature' => EventPricingFeature::class,
            default => null
        };

        if ($model) {
            foreach ($ids as $index => $id) {
                $model::where('id', $id)->update(['order' => $index]);
            }
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
}
