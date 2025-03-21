<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    public function run()
    {
        $sections = [
            ['id' => 1, 'name' => 'about', 'title' => 'What We Do', 'description' => 'We develop big ideas that sell', 'image' => 'landing/images/startup-bg.jpg', 'is_active' => 1, 'show_order' => 0],
            ['id' => 2, 'name' => 'contact', 'title' => 'Contact Us', 'description' => '- Stay in Touch -', 'is_active' => 1, 'show_order' => 0],
            ['id' => 3, 'name' => 'counter', 'title' => 'Our Achievements', 'description' => 'We have achieved great milestones over the years.', 'is_active' => 1, 'show_order' => 0],
            ['id' => 4, 'name' => 'portofolio', 'title' => 'Our Work', 'description' => 'Explore our best projects in various categories.', 'is_active' => 1, 'show_order' => 0],
            ['id' => 5, 'name' => 'pricing', 'title' => 'Our Pricing', 'description' => '- Choose Your Plan -', 'is_active' => 1, 'show_order' => 0],
            ['id' => 6, 'name' => 'services', 'title' => 'Our Services', 'description' => '- Design your presence -', 'is_active' => 1, 'show_order' => 0],
            ['id' => 7, 'name' => 'team', 'title' => 'Meet Our Team', 'description' => '- We Are Stronger -', 'is_active' => 1, 'show_order' => 0],
            ['id' => 8, 'name' => 'testimonials', 'title' => 'Testimonials', 'description' => '- Happy Clients -', 'is_active' => 1, 'show_order' => 0],
            ['id' => 9, 'name' => 'who', 'title' => 'Who We Are', 'description' => '- The way we work is fun -', 'is_active' => 1, 'show_order' => 0],
            ['id' => 10, 'name' => 'home', 'title' => 'Welcome to Boys Project', 'description' => 'Jual beli sparepart motor & pemasangan terpercaya', 'is_active' => 1, 'show_order' => 1],
            ['id' => 11, 'name' => 'tiktok', 'title' => 'Our TikTok Content', 'description' => 'Latest updates from TikTok', 'is_active' => 1, 'show_order' => 8],
            ['id' => 12, 'name' => 'instagram', 'title' => 'Our Instagram Posts', 'description' => 'Latest updates from Instagram', 'is_active' => 1, 'show_order' => 9],
        ];

        DB::table('sections')->insert($sections);
    }
}
