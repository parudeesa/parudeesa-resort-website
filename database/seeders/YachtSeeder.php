<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YachtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Yacht::create([
            'name' => 'Premium Yacht Service',
            'description' => 'Experience the ultimate luxury on our private yacht. Perfect for curated dining, scenic lake views, and exclusive celebrations with your loved ones.',
            'price' => 15000,
            'duration' => '5 Hours',
            'capacity' => 10,
            'image_url' => 'https://images.unsplash.com/photo-1569263979104-865ab7cd8d13?w=1400&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
                'https://images.unsplash.com/photo-1605281317010-fe5ffe798156?w=800&q=80',
                'https://images.unsplash.com/photo-1567896836024-e3cad9653106?w=800&q=80',
            ],
            'status' => true,
        ]);
    }
}
