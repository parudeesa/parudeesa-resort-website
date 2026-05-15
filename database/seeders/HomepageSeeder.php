<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomepageSeeder extends Seeder
{
    public function run(): void
    {
        // Home Amenities
        $amenities = [
            ['title' => 'Infinity Pool', 'image' => 'images/experiences/infinity-pool.png', 'order' => 0],
            ['title' => 'Campfire Area', 'image' => 'images/experiences/campfire.png', 'order' => 1],
            ['title' => 'Boating Experience', 'image' => 'images/experiences/boating.png', 'order' => 2],
            ['title' => 'Lakeside Events', 'image' => 'images/experiences/event-space.png', 'order' => 3],
            ['title' => 'Free WiFi', 'image' => 'images/experiences/wifi.png', 'order' => 4],
            ['title' => 'Parking Facility', 'image' => 'images/experiences/parking.png', 'order' => 5],
        ];

        foreach ($amenities as $amenity) {
            \App\Models\HomeAmenity::create($amenity);
        }

        // Placeholder Reviews (if needed)
        $reviews = [
            [
                'name' => 'Rahul Sharma',
                'text' => 'An absolutely magical experience. The lakeside views are breathtaking!',
                'stars' => 5,
                'order' => 0
            ],
            [
                'name' => 'Anjali Nair',
                'text' => 'The perfect getaway from the city. The hospitality is top-notch.',
                'stars' => 5,
                'order' => 1
            ],
        ];

        foreach ($reviews as $review) {
            \App\Models\HomeReview::create($review);
        }
    }
}
