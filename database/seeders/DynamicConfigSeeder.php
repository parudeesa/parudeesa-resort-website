<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DynamicConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 1. Food Packages
        $foodPackages = [
            ['name' => 'Stay Only', 'price' => 0, 'description' => 'Standard stay without meals'],
            ['name' => 'Stay + Breakfast + Tea & Snacks', 'price' => 200, 'description' => 'Morning breakfast and evening snacks'],
            ['name' => 'Stay + Breakfast + Tea & Snacks + Dinner', 'price' => 450, 'description' => 'Complete meal package']
        ];
        foreach ($foodPackages as $pkg) {
            \App\Models\FoodPackage::updateOrCreate(['name' => $pkg['name']], $pkg);
        }

        // 2. Event Services
        $eventServices = [
            ['name' => 'Decoration', 'icon' => 'bi-flower1', 'price' => 0],
            ['name' => 'Food & Catering', 'icon' => 'bi-cup-hot', 'price' => 0],
            ['name' => 'Photography', 'icon' => 'bi-camera', 'price' => 0],
            ['name' => 'DJ Setup', 'icon' => 'bi-music-note-beamed', 'price' => 0],
            ['name' => 'Live Music', 'icon' => 'bi-mic-fill', 'price' => 0],
            ['name' => 'Foam Party', 'icon' => 'bi-cloud-haze2', 'price' => 0],
            ['name' => 'Pool Party', 'icon' => 'bi-water', 'price' => 0],
            ['name' => 'Boat Ride', 'icon' => 'bi-tsunami', 'price' => 0]
        ];
        foreach ($eventServices as $svc) {
            \App\Models\EventService::updateOrCreate(['name' => $svc['name']], $svc);
        }

        // 3. Update existing properties with default pricing
        $properties = \App\Models\Property::all();
        foreach ($properties as $p) {
            $p->update([
                'weekday_price' => 8000,
                'weekend_price' => 12000,
                'base_guests' => 5,
                'extra_guest_price' => 600,
                'max_guests' => 15
            ]);
        }

        // 4. Update Settings
        $settings = [
            ['key' => 'check_in_time', 'value' => '02:00 PM', 'type' => 'text', 'group' => 'booking'],
            ['key' => 'check_out_time', 'value' => '11:00 AM', 'type' => 'text', 'group' => 'booking'],
            ['key' => 'water_activity_threshold', 'value' => '5', 'type' => 'number', 'group' => 'amenity_rules'],
            ['key' => 'water_activity_low_price', 'value' => '1000', 'type' => 'number', 'group' => 'amenity_rules'],
            ['key' => 'water_activity_high_price', 'value' => '700', 'type' => 'number', 'group' => 'amenity_rules'],
        ];
        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
