<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingSection;

class LandingSectionSeeder extends Seeder
{
    public function run(): void
    {
        LandingSection::insert([
            [
                'section_name' => 'counter',
                'content' => '<h2>5600+ Working Hours</h2>',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'section_name' => 'services',
                'content' => '<h2>Our Services</h2>',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'section_name' => 'team',
                'content' => '<h2>Meet Our Team</h2>',
                'is_active' => true,
                'order' => 3,
            ]
        ]);
    }
}
