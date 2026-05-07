<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertyGallerySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Find the property "Parudeesa The Paradise"
        $property = Property::where('name', 'Parudeesa The Paradise')->first();

        if ($property) {
            // 2. Add your local image paths here
            // Make sure you copy your PNG files to: public/images/gallery/
            $images = [
                '/images/gallery/image1.png',
                '/images/gallery/image2.png',
                '/images/gallery/image3.png',
                '/images/gallery/image4.png',
                '/images/gallery/image5.png',
            ];

            // 3. Update the property
            $property->update([
                'gallery_images' => $images
            ]);

            $this->command->info('Gallery images updated for Parudeesa The Paradise!');
        } else {
            $this->command->error('Property not found.');
        }
    }
}
