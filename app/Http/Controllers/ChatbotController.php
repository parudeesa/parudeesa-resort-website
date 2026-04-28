<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Property;
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

                return [
                    'id' => $property->id,
                    'name' => $property->name,
                    'price' => (float) ($property->price ?? 0),
                    'location' => $property->location,
                    'amenities' => $amenities->map(function ($amenity) {
                        return [
                            'id' => $amenity->id,
                            'name' => $amenity->name,
                            'price' => (float) $amenity->price,
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
            'selectedPropertyId' => $request->integer('property_id') ?: null,
            'isEmbed' => $request->boolean('embed'),
        ]);
    }
}
