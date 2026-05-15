<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // HERO SECTION
            [
                'key' => 'home_hero_title',
                'value' => 'Parudeesa',
                'type' => 'text',
                'group' => 'home_hero'
            ],
            [
                'key' => 'home_hero_bg',
                'value' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1800&q=85',
                'type' => 'image',
                'group' => 'home_hero'
            ],

            // PROPERTIES SECTION
            [
                'key' => 'home_prop_title',
                'value' => 'Two <em>Lakeside</em> Jewels',
                'type' => 'text',
                'group' => 'home_properties'
            ],
            [
                'key' => 'home_prop_subtitle',
                'value' => 'Handpicked Retreats',
                'type' => 'text',
                'group' => 'home_properties'
            ],
            [
                'key' => 'home_prop_desc',
                'value' => 'Each property offers unobstructed sunset views, private lake access, and curated experiences.',
                'type' => 'textarea',
                'group' => 'home_properties'
            ],

            // AMENITIES SECTION
            [
                'key' => 'home_amenities_title',
                'value' => 'What <em style="color:var(--brand-l)">Awaits</em> You',
                'type' => 'text',
                'group' => 'home_amenities'
            ],
            [
                'key' => 'home_amenities_subtitle',
                'value' => 'Experiences',
                'type' => 'text',
                'group' => 'home_amenities'
            ],

            // EVENTS SECTION
            [
                'key' => 'home_events_title',
                'value' => 'Make Every Moment <em style="color:var(--brand-l);font-style:italic">Unforgettable</em>',
                'type' => 'text',
                'group' => 'home_events'
            ],
            [
                'key' => 'home_events_subtitle',
                'value' => 'CELEBRATIONS AT PARUDEESA',
                'type' => 'text',
                'group' => 'home_events'
            ],
            [
                'key' => 'home_events_desc',
                'value' => 'Premier lakeside events destination.',
                'type' => 'textarea',
                'group' => 'home_events'
            ],
            [
                'key' => 'home_events_bg',
                'value' => '/images/event-hero-main.jpg',
                'type' => 'image',
                'group' => 'home_events'
            ],

            // REVIEWS SECTION
            [
                'key' => 'home_reviews_title',
                'value' => 'Memories <em>Made Here</em>',
                'type' => 'text',
                'group' => 'home_reviews'
            ],
            [
                'key' => 'home_reviews_subtitle',
                'value' => 'Guest Reviews',
                'type' => 'text',
                'group' => 'home_reviews'
            ],
            [
                'key' => 'home_reviews_badge',
                'value' => '5.0 - Google Reviews - 200+ Happy Guests',
                'type' => 'text',
                'group' => 'home_reviews'
            ],

            // ABOUT SECTION
            [
                'key' => 'home_about_title',
                'value' => 'Born from a Love of <em>Kerala\'s Waters</em>',
                'type' => 'text',
                'group' => 'home_about'
            ],
            [
                'key' => 'home_about_description',
                'value' => 'Parudeesa — meaning "paradise" — was born from a deep love of Kerala\'s serene backwaters and a vision to share that peace with the world.',
                'type' => 'textarea',
                'group' => 'home_about'
            ],
            [
                'key' => 'home_about_image',
                'value' => 'https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=700&q=80',
                'type' => 'image',
                'group' => 'home_about'
            ],

            // CONTACT INFO
            [
                'key' => 'contact_address',
                'value' => 'Parudeesa Resort, Kerala Backwaters, India',
                'type' => 'textarea',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+91 89210 21202',
                'type' => 'text',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_phone_2',
                'value' => '+91 80757 41948',
                'type' => 'text',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_email',
                'value' => 'hello@parudeesa.in',
                'type' => 'text',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_map_iframe',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.9!2d76.3!3d9.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwNTQnMDAuMCJOIDc2wrAxOCc0OC4wIkU!5e0!3m2!1sen!2sin!4v1620000000000!5m2!1sen!2sin',
                'type' => 'textarea',
                'group' => 'contact'
            ],

            // REELS SECTION
            [
                'key' => 'home_reel_1_img',
                'value' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80',
                'type' => 'image',
                'group' => 'home_reels'
            ],
            [
                'key' => 'home_reel_1_link',
                'value' => 'https://www.instagram.com/Parudeesa_the_paradise',
                'type' => 'text',
                'group' => 'home_reels'
            ],
            [
                'key' => 'home_reel_1_caption',
                'value' => 'Sunrise Views',
                'type' => 'text',
                'group' => 'home_reels'
            ],

            [
                'key' => 'home_reel_2_img',
                'value' => 'https://images.unsplash.com/photo-1610641818989-c2051b5e2cfd?w=600&q=80',
                'type' => 'image',
                'group' => 'home_reels'
            ],
            [
                'key' => 'home_reel_2_link',
                'value' => 'https://www.instagram.com/Parudeesa_the_paradise',
                'type' => 'text',
                'group' => 'home_reels'
            ],
            [
                'key' => 'home_reel_2_caption',
                'value' => 'Lakeside Serenity',
                'type' => 'text',
                'group' => 'home_reels'
            ],

            [
                'key' => 'home_reel_3_img',
                'value' => 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=600&q=80',
                'type' => 'image',
                'group' => 'home_reels'
            ],
            [
                'key' => 'home_reel_3_link',
                'value' => 'https://www.instagram.com/Parudeesa_the_paradise',
                'type' => 'text',
                'group' => 'home_reels'
            ],
            [
                'key' => 'home_reel_3_caption',
                'value' => 'Luxury Stay',
                'type' => 'text',
                'group' => 'home_reels'
            ],

            [
                'key' => 'home_reel_4_img',
                'value' => 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=600&q=80',
                'type' => 'image',
                'group' => 'home_reels'
            ],
            [
                'key' => 'home_reel_4_link',
                'value' => 'https://www.instagram.com/Parudeesa_the_paradise',
                'type' => 'text',
                'group' => 'home_reels'
            ],
            [
                'key' => 'home_reel_4_caption',
                'value' => 'Celebrations',
                'type' => 'text',
                'group' => 'home_reels'
            ],

            [
                'key' => 'home_reel_5_img',
                'value' => 'https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=600&q=80',
                'type' => 'image',
                'group' => 'home_reels'
            ],
            [
                'key' => 'home_reel_5_link',
                'value' => 'https://www.instagram.com/Parudeesa_the_paradise',
                'type' => 'text',
                'group' => 'home_reels'
            ],
            [
                'key' => 'home_reel_5_caption',
                'value' => 'Magic Hour',
                'type' => 'text',
                'group' => 'home_reels'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
