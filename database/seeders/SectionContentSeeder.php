<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionContentSeeder extends Seeder
{
    public function run()
    {
        $sectionContents = [
            ['id' => 1, 'section_id' => 1, 'content_key' => 'Creative Design', 'content_value' => 'Designing a good website that accommodates a lot of content is a tricky balancing act to pull off.', 'type' => 'text', 'extra_data' => null, 'show_order' => 0],
            ['id' => 2, 'section_id' => 1, 'content_key' => 'Web Development', 'content_value' => 'We build mobile apps for the conference, integrating unique content and branding to create.', 'type' => 'text', 'extra_data' => null, 'show_order' => 0],
            ['id' => 3, 'section_id' => 1, 'content_key' => 'Marketing Support', 'content_value' => 'Google has made this important since 1998 when it launched. Content became, and still is king since websites.', 'type' => 'text', 'extra_data' => null, 'show_order' => 0],
            ['id' => 4, 'section_id' => 2, 'content_key' => 'email', 'content_value' => 'info@example.com', 'type' => 'text', 'extra_data' => null, 'show_order' => 0],
            ['id' => 5, 'section_id' => 2, 'content_key' => 'phone', 'content_value' => '+1234567890', 'type' => 'text', 'extra_data' => null, 'show_order' => 0],
            ['id' => 6, 'section_id' => 2, 'content_key' => 'address', 'content_value' => '123 Street Name, City, Country', 'type' => 'text', 'extra_data' => null, 'show_order' => 0],
            ['id' => 7, 'section_id' => 3, 'content_key' => 'Working Hours', 'content_value' => '5600', 'type' => 'number', 'extra_data' => null, 'show_order' => 0],
            ['id' => 8, 'section_id' => 3, 'content_key' => 'Happy Clients', 'content_value' => '220', 'type' => 'number', 'extra_data' => null, 'show_order' => 0],
            ['id' => 9, 'section_id' => 3, 'content_key' => 'Awards', 'content_value' => '108', 'type' => 'number', 'extra_data' => null, 'show_order' => 0],
            ['id' => 10, 'section_id' => 3, 'content_key' => 'Projects a Year', 'content_value' => '650', 'type' => 'number', 'extra_data' => null, 'show_order' => 0],
            ['id' => 11, 'section_id' => 4, 'content_key' => 'Business Cards', 'content_value' => 'Print Design', 'type' => 'image', 'extra_data' => json_encode(['image' => 'landing/images/portfolio/grid/1.jpg', 'categories' => 'print, branding', 'link' => '#']), 'show_order' => 0],
            ['id' => 12, 'section_id' => 4, 'content_key' => 'Magazine', 'content_value' => 'Branding', 'type' => 'image', 'extra_data' => json_encode(['image' => 'landing/images/portfolio/grid/2.jpg', 'categories' => 'branding', 'link' => '#']), 'show_order' => 0],
            ['id' => 13, 'section_id' => 4, 'content_key' => 'Rabycad CD Design', 'content_value' => 'Branding', 'type' => 'image', 'extra_data' => json_encode(['image' => 'landing/images/portfolio/grid/3.jpg', 'categories' => 'branding', 'link' => '#']), 'show_order' => 0],
            ['id' => 38, 'section_id' => 11, 'content_key' => 'TikTok Video 1', 'content_value' => null, 'type' => 'text', 'extra_data' => json_encode(['embed_url' => 'https://www.tiktok.com/@boyprojects/video/7482575523772779831', 'video_id' => '7482575523772779831']), 'show_order' => 0],
            ['id' => 39, 'section_id' => 11, 'content_key' => 'TikTok Video 2', 'content_value' => null, 'type' => 'text', 'extra_data' => json_encode(['embed_url' => 'https://www.tiktok.com/@boyprojects/photo/7483462663515753736', 'video_id' => '7483462663515753736']), 'show_order' => 0],
            ['id' => 40, 'section_id' => 12, 'content_key' => 'Instagram Post 1', 'content_value' => null, 'type' => 'text', 'extra_data' => json_encode(['embed_url' => 'https://www.instagram.com/p/XYZ123/']), 'show_order' => 0],
            ['id' => 41, 'section_id' => 12, 'content_key' => 'Instagram Post 2', 'content_value' => null, 'type' => 'text', 'extra_data' => json_encode(['embed_url' => 'https://www.instagram.com/p/ABC789/']), 'show_order' => 0],
        ];

        DB::table('section_contents')->insert($sectionContents);
    }
}
