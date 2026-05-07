<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            ['name' => 'Swimming Pool', 'description' => 'Private infinity pool with lake views', 'price' => 0, 'pricing_type' => 'fixed'],
            ['name' => 'WiFi', 'description' => 'High-speed internet throughout the property', 'price' => 0, 'pricing_type' => 'fixed'],
            ['name' => 'Air Conditioning', 'description' => 'Central AC in all rooms', 'price' => 0, 'pricing_type' => 'fixed'],
            ['name' => 'Kitchen', 'description' => 'Fully equipped modern kitchen', 'price' => 0, 'pricing_type' => 'fixed'],
            ['name' => 'Parking', 'description' => 'Secure parking space', 'price' => 0, 'pricing_type' => 'fixed'],
            ['name' => 'Lake View', 'description' => 'Direct lake access and views', 'price' => 0, 'pricing_type' => 'fixed'],
            ['name' => 'Fireplace', 'description' => 'Cozy fireplace for evening relaxation', 'price' => 0, 'pricing_type' => 'fixed'],
            ['name' => 'Garden', 'description' => 'Beautiful landscaped garden', 'price' => 0, 'pricing_type' => 'fixed'],
            ['name' => 'Premium Yacht', 'description' => 'Premium yacht add-on', 'price' => 0, 'pricing_type' => 'fixed'],
            ['name' => 'Canopy Boat Pickup Experience', 'description' => 'Boat pickup to the kayaking center with refreshments provided.', 'price' => 700, 'pricing_type' => 'per_person'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::updateOrCreate(['name' => $amenity['name']], $amenity + ['status' => true]);
        }
    }
}
