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
            ['name' => 'Kayaking', 'description' => 'Enjoy kayaking on the lake'],
            ['name' => 'Boating', 'description' => 'Relaxing boat rides'],
            ['name' => 'Grilling', 'description' => 'Outdoor BBQ and grilling area'],
            ['name' => 'Fishing', 'description' => 'Fishing spots available'],
            ['name' => 'Campfire', 'description' => 'Evening campfire setup'],
            ['name' => 'Hookah(Shisha)', 'description' => 'Hookah/Shisha available on request'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create($amenity);
        }
    }
}
