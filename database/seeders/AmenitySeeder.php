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
            ['name' => 'Kayaking', 'description' => 'Enjoy kayaking on the lake', 'price' => 700, 'pricing_type' => 'per_person'],
            ['name' => 'Boating', 'description' => 'Relaxing boat rides', 'price' => 600, 'pricing_type' => 'per_person'],
            ['name' => 'Grilling', 'description' => 'Outdoor BBQ and grilling area', 'price' => 1000, 'pricing_type' => 'fixed'],
            ['name' => 'Fishing', 'description' => 'Fishing spots available', 'price' => 500, 'pricing_type' => 'per_person'],
            ['name' => 'Campfire', 'description' => 'Evening campfire setup', 'price' => 1500, 'pricing_type' => 'fixed'],
            ['name' => 'Hookah/Shisha', 'description' => 'Hookah/Shisha available on request', 'price' => 300, 'pricing_type' => 'per_person'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create($amenity);
        }
    }
}
