<?php

namespace App\Http\Controllers;

use App\Models\EventInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function index()
    {
        $hero = json_decode(\App\Models\Setting::get('events_hero', '{}'), true);
        $pricing = json_decode(\App\Models\Setting::get('events_pricing', '{}'), true);
        $seo = json_decode(\App\Models\Setting::get('events_seo', '{}'), true);
        
        $cards = \App\Models\EventCard::where('status', true)->orderBy('order')->get();
        
        $amenities = \App\Models\EventAmenity::where('status', true)
            ->get()
            ->sortBy(function($amenity) {
                $priority = [
                    'Swimming Pool' => 1,
                    'DJ & Music' => 2,
                    'Boat Rides' => 3,
                    'Lakeside Property' => 4,
                ];
                return $priority[$amenity->title] ?? 99;
            });

        $gallery = \App\Models\EventGallery::where('status', true)->orderBy('order')->get();
        $steps = \App\Models\EventStep::where('status', true)->orderBy('order')->get();
        $pricingFeatures = \App\Models\EventPricingFeature::where('status', true)->orderBy('order')->get();
        $reels = \App\Models\Reel::where('is_active', true)->orderBy('order')->get();

        return view('events', compact(
            'hero', 'pricing', 'seo', 'cards', 'amenities', 'gallery', 'steps', 'pricingFeatures', 'reels'
        ));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|regex:/^[0-9]{10}$/',
                'email' => 'nullable|email|max:255',
                'event_type' => 'required|string',
                'event_date' => 'required|date',
                'event_time' => 'nullable|string',
                'guests' => 'required|integer|min:1',
                'need_stay' => 'nullable|string',
                'property_id' => 'nullable|exists:properties,id',
                'stay_guests' => 'nullable|integer|min:1',
                'check_in' => 'nullable|date',
                'check_out' => 'nullable|date',
                'stay_duration' => 'nullable|string',
                'event_duration' => 'nullable|string',
                'budget' => 'nullable|string',
                'requirements' => 'nullable|array',
                'notes' => 'nullable|string'
            ]);

            $inquiry = EventInquiry::create($validated);
            
            Log::info('New Event Inquiry Saved:', ['id' => $inquiry->id]);

            return response()->json([
                'success' => true,
                'message' => 'Your vision for a perfect celebration has been received. Our event concierge will contact you within 24 hours.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please check the form for errors.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Event Inquiry Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Sorry, something went wrong. Please try again or contact us directly.'
            ], 500);
        }
    }
}
