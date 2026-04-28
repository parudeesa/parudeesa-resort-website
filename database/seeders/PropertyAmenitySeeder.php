<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\Amenity;

class PropertyAmenitySeeder extends Seeder
{
    public function run(): void
    {
        $properties = Property::all();
        $amenities = Amenity::all();

        foreach ($properties as $property) {
            $property->amenities()->attach($amenities->pluck('id'));
        }
    }
}