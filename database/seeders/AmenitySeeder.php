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
            ['name' => 'Swimming Pool', 'description' => 'Private infinity pool with lake views'],
            ['name' => 'WiFi', 'description' => 'High-speed internet throughout the property'],
            ['name' => 'Air Conditioning', 'description' => 'Central AC in all rooms'],
            ['name' => 'Kitchen', 'description' => 'Fully equipped modern kitchen'],
            ['name' => 'Parking', 'description' => 'Secure parking space'],
            ['name' => 'Lake View', 'description' => 'Direct lake access and views'],
            ['name' => 'Fireplace', 'description' => 'Cozy fireplace for evening relaxation'],
            ['name' => 'Garden', 'description' => 'Beautiful landscaped garden'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create($amenity);
        }
    }
}
