<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;
use App\Models\Property;

class UpdateAmenitiesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Remove/Disable Canopy Boat Pickup Experience
        Amenity::where('name', 'Canopy Boat Pickup Experience')->delete();
        
        // Also remove old separate ones if they exist
        Amenity::where('name', 'Kayaking')->delete();
        Amenity::where('name', 'Boating')->delete();

        // 2. Define New/Updated Amenities
        $amenities = [
            [
                'name' => 'Kayaking & Boating',
                'description' => 'Scenic sunset trails and group leisure rides.',
                'price' => 700,
                'pricing_type' => 'per_person',
                'image_url' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&q=80',
                'condition_note' => '₹1000 / person (below 5 people)',
                'is_premium' => false,
            ],
            [
                'name' => 'Campfire',
                'description' => 'Cozy evening fire pit experience.',
                'price' => 1000,
                'pricing_type' => 'fixed',
                'image_url' => 'https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?w=600&q=80',
                'is_premium' => false,
            ],
            [
                'name' => 'JBL Party Speaker',
                'description' => 'High-quality sound for your outdoor party.',
                'price' => 1000,
                'pricing_type' => 'fixed',
                'image_url' => 'https://images.unsplash.com/photo-1590602847861-f357a9332bbc?w=600&q=80',
                'is_premium' => false,
            ],
            [
                'name' => 'Sheesha',
                'description' => 'Premium flavors for a relaxed evening.',
                'price' => 500,
                'pricing_type' => 'fixed',
                'image_url' => 'https://images.unsplash.com/photo-1510007551061-000c017dfce7?w=600&q=80',
                'is_premium' => false,
            ],
            [
                'name' => 'Premium Yacht Service',
                'description' => 'Luxury private yacht experience with curated dining and scenic views.',
                'price' => 15000,
                'pricing_type' => 'fixed',
                'image_url' => 'https://images.unsplash.com/photo-1569263979104-865ab7cd8d13?w=1400&q=80',
                'is_premium' => true,
            ],
        ];

        foreach ($amenities as $data) {
            $amenity = Amenity::updateOrCreate(['name' => $data['name']], $data + ['status' => true]);
            
            // Link to all properties
            $propertyIds = Property::pluck('id')->toArray();
            $amenity->properties()->syncWithoutDetaching($propertyIds);
        }
    }
}
