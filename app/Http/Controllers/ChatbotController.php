<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Property;
use App\Models\Yacht;
use App\Models\EventCard;
use App\Models\Setting;
use App\Models\BlockedDate;
use App\Models\Booking;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function show(Request $request)
    {
        $properties = collect();
        $chatbotProperties = [];
        
        try {
            $allAmenities = Amenity::where('status', true)->orderBy('name')->get();

            $properties = Property::with(['amenities' => function ($query) {
                $query->where('status', true)->orderBy('name');
            }])->orderBy('name')->get();

            $chatbotProperties = $properties->map(function ($property) use ($allAmenities) {
                $amenities = $property->amenities->isNotEmpty() ? $property->amenities : $allAmenities;

                $disabledDates = [];
                
                // Fetch blocked date ranges
                BlockedDate::where('property_id', $property->id)->get()->each(function($b) use (&$disabledDates) {
                    if ($b->start_date && $b->end_date) {
                        $disabledDates[] = [
                            'from' => $b->start_date->toDateString(),
                            'to' => $b->end_date->toDateString()
                        ];
                    }
                });

                // Fetch existing bookings
                Booking::where('property_id', $property->id)
                    ->where('status', '!=', 'cancelled')
                    ->where(function ($query) {
                        $query->whereNull('payment_status')
                            ->orWhereIn('payment_status', ['Pending', 'Paid']);
                    })
                    ->get()
                    ->each(function($b) use (&$disabledDates) {
                        if ($b->check_in && $b->check_out) {
                            $disabledDates[] = [
                                'from' => $b->check_in->toDateString(),
                                'to' => $b->check_out->subDay()->toDateString()
                            ];
                        }
                    });

                return [
                    'id' => $property->id,
                    'name' => $property->name,
                    'description' => $property->description,
                    'tagline' => 'Luxury Lakeside Retreat',
                    'price' => (float) ($property->price ?? 8000),
                    'capacity' => $property->capacity,
                    'location' => $property->location,
                    'image' => asset($property->image),
                    'gallery' => $property->gallery_images ?? [],
                    'highlights' => $property->highlights ?? [],
                    'accommodation' => $property->accommodation ?? [],
                    'outdoor_spaces' => $property->outdoor_spaces ?? [],
                    'disabled_dates' => $disabledDates,
                    'amenities' => $amenities->map(function ($amenity) {
                        return [
                            'id' => $amenity->id,
                            'name' => $amenity->name,
                            'price' => (float) $amenity->price,
                            'image' => asset($amenity->image),
                            'pricing_type' => $amenity->pricing_type,
                            'description' => $amenity->description,
                        ];
                    })->values(),
                ];
            })->values()->toArray();
        } catch (\Exception $e) {
            // Fallback to empty data if database is unavailable
            \Log::error('Chatbot database error: ' . $e->getMessage());
        }

        return view('chatbot', [
            'properties' => $properties,
            'chatbotProperties' => $chatbotProperties,
            'yachts' => Yacht::where('status', true)->get()->map(function($y) {
                return [
                    'id' => $y->id,
                    'name' => $y->name,
                    'price' => (float) $y->price,
                    'capacity' => $y->capacity,
                    'image' => asset($y->image),
                ];
            }),
            'eventCards' => EventCard::where('status', true)->orderBy('order')->get()->map(function($e) {
                $e->image = asset($e->image);
                return $e;
            }),
            'activeCoupons' => \App\Models\Coupon::where('is_active', true)->get(),
            'selectedPropertyId' => $request->integer('property_id') ?: null,
            'isEmbed' => $request->boolean('embed'),
            'settings' => Setting::pluck('value', 'key'),
        ]);
    }
}
