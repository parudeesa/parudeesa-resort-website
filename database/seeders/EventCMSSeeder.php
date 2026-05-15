<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventCMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Hero Settings
        \App\Models\Setting::updateOrCreate(
            ['key' => 'events_hero', 'group' => 'events_page'],
            ['value' => json_encode([
                'eyebrow' => 'Parudeesa Lakeside Resort',
                'title' => 'Host <em>unforgettable</em><br>celebrations by the lake',
                'subtitle' => 'From intimate gatherings to grand weddings — we craft bespoke lakeside experiences that linger in memory long after the last toast.',
                'image' => '/images/event-hero-main.jpg',
                'cta_1_text' => 'Plan Your Event',
                'cta_1_link' => '#inquiry',
                'cta_2_text' => 'Get Custom Quote',
                'cta_2_link' => '#pricing',
                'status' => true
            ]), 'type' => 'json']
        );

        // 2. Events We Host (Event Cards)
        $cards = [
            ['title' => 'Birthday Parties', 'icon' => '🎂'],
            ['title' => 'Bride / Groom To Be', 'icon' => '💍'],
            ['title' => 'Pre-Wedding Celebrations', 'icon' => '🌸'],
            ['title' => 'Weddings', 'icon' => '💒'],
            ['title' => 'Gender Reveal Parties', 'icon' => '👶'],
            ['title' => 'Honeymoon Staycation', 'icon' => '🍯'],
            ['title' => 'Day Out & Corporate', 'icon' => '🏢'],
            ['title' => 'Family Gatherings', 'icon' => '🌿'],
        ];

        foreach ($cards as $index => $card) {
            \App\Models\EventCard::create([
                'title' => $card['title'],
                'icon' => $card['icon'],
                'order' => $index,
                'status' => true
            ]);
        }

        // 3. Custom Pricing Settings
        \App\Models\Setting::updateOrCreate(
            ['key' => 'events_pricing', 'group' => 'events_page'],
            ['value' => json_encode([
                'label' => 'Tailored To You',
                'title' => 'Custom <em>pricing</em><br>for every vision',
                'subtitle' => 'Our pricing is thoughtfully crafted around your unique needs. Tell us what you envision, and we\'ll handle the rest.',
                'image' => '/images/events-custom.png',
                'cta_text' => 'REQUEST CUSTOM QUOTE',
                'badge_label' => 'STARTING FROM',
                'badge_value' => 'Bespoke',
                'status' => true
            ]), 'type' => 'json']
        );

        // 4. Pricing Features
        $features = [
            ['text' => 'Guest Count', 'icon' => 'bi-people'],
            ['text' => 'Stay Included', 'icon' => 'bi-house'],
            ['text' => 'Decoration', 'icon' => 'bi-flower1'],
            ['text' => 'Food & Catering', 'icon' => 'bi-cup-hot'],
            ['text' => 'Photography', 'icon' => 'bi-camera'],
            ['text' => 'DJ Setup', 'icon' => 'bi-music-player'],
            ['text' => 'Live Music', 'icon' => 'bi-mic'],
            ['text' => 'Pool Party', 'icon' => 'bi-droplet'],
        ];

        foreach ($features as $index => $feature) {
            \App\Models\EventPricingFeature::create([
                'text' => $feature['text'],
                'icon' => $feature['icon'],
                'order' => $index,
                'status' => true
            ]);
        }

        // 5. Amenities
        $amenities = [
            ['title' => 'Lakeside Property', 'description' => 'Nestled by the edge with panoramic views of the backwaters.', 'icon' => '🏞️'],
            ['title' => 'Luxury Rooms', 'description' => 'Well-appointed suites for guests to rest in ultimate comfort.', 'icon' => '🛏️'],
            ['title' => 'Event Lawn', 'description' => 'Sprawling manicured lawn perfect for grand outdoor celebrations.', 'icon' => '🌿'],
            ['title' => 'Swimming Pool', 'description' => 'Stunning infinity-style pool overlooking the serene landscape.', 'icon' => '🏊'],
            ['title' => 'Bonfire', 'description' => 'Curated evening bonfire under the starlit lakeside sky.', 'icon' => '🔥'],
            ['title' => 'DJ & Music', 'description' => 'Professional sound systems and entertainment on request.', 'icon' => '🎧'],
            ['title' => 'Catering', 'description' => 'Bespoke culinary experiences crafted by seasoned chefs.', 'icon' => '🍽️'],
            ['title' => 'Boat Rides', 'description' => 'Exclusive access to the backwaters for you and your guests.', 'icon' => '🚤'],
        ];

        foreach ($amenities as $index => $amenity) {
            \App\Models\EventAmenity::create([
                'title' => $amenity['title'],
                'description' => $amenity['description'],
                'icon' => $amenity['icon'],
                'order' => $index,
                'status' => true
            ]);
        }

        // 6. Gallery
        $galleryItems = [
            ['image' => 'https://images.unsplash.com/photo-1519741347686-c1e0aadf4611?w=600&q=80', 'category' => 'Lakeside Wedding'],
            ['image' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=600&q=80', 'category' => 'Poolside Fun'],
            ['image' => 'https://images.unsplash.com/photo-1531058020387-3be344556be6?w=600&q=80', 'category' => 'Moonlight Magic'],
            ['image' => 'https://images.unsplash.com/photo-1527529482837-4698179dc6ce?w=600&q=80', 'category' => 'Sunsets'],
            ['image' => 'https://images.unsplash.com/photo-1510076857177-7470076d4098?w=600&q=80', 'category' => 'Gatherings'],
            ['image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80', 'category' => 'Nature'],
        ];

        foreach ($galleryItems as $index => $item) {
            \App\Models\EventGallery::create([
                'image' => $item['image'],
                'category' => $item['category'],
                'order' => $index,
                'status' => true
            ]);
        }

        // 7. Journey Steps
        $steps = [
            ['title' => 'Submit Vision', 'description' => 'Tell us about your dream celebration through our quick inquiry form.', 'step_number' => 1],
            ['title' => 'Discuss Details', 'description' => 'Our event experts contact you to refine every fine detail of your vision.', 'step_number' => 2],
            ['title' => 'Host Event', 'description' => 'Receive your custom quote and get ready for a magical lakeside day.', 'step_number' => 3],
        ];

        foreach ($steps as $index => $step) {
            \App\Models\EventStep::create([
                'title' => $step['title'],
                'description' => $step['description'],
                'step_number' => $step['step_number'],
                'order' => $index,
                'status' => true
            ]);
        }

        // 8. SEO Settings
        \App\Models\Setting::updateOrCreate(
            ['key' => 'events_seo', 'group' => 'events_page'],
            ['value' => json_encode([
                'title' => 'Parudeesa — Lakeside Events',
                'description' => 'Host unforgettable celebrations by the lake. From intimate gatherings to grand weddings.',
                'og_image' => '/images/event-hero-main.jpg',
                'schema_markup' => ''
            ]), 'type' => 'json']
        );
    }
}
