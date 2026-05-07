<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventPackage;

class EventPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventPackages = [
            ['name' => 'Wedding Package', 'description' => 'Complete wedding package including venue, catering, and decorations', 'price' => 50000, 'pricing_type' => 'fixed'],
            ['name' => 'Corporate Event Package', 'description' => 'Professional setup for meetings, conferences, and team building', 'price' => 20000, 'pricing_type' => 'fixed'],
            ['name' => 'Birthday Party Package', 'description' => 'Fun package for birthday celebrations with games and catering', 'price' => 10000, 'pricing_type' => 'fixed'],
            ['name' => 'Anniversary Package', 'description' => 'Romantic package for anniversary celebrations', 'price' => 15000, 'pricing_type' => 'fixed'],
        ];

        foreach ($eventPackages as $package) {
            EventPackage::updateOrCreate(['name' => $package['name']], $package + ['status' => true]);
        }
    }
}
