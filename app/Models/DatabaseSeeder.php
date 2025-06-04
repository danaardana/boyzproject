<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\ContactMessage;
use App\Models\Section;
use App\Models\SectionContent;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create test customers
        $customers = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '1234567890',
                'address' => '123 Main St, City',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '0987654321',
                'address' => '456 Oak Ave, Town',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Create test messages
        $messages = [
            [
                'customer_id' => 1,
                'content_key' => 'Product Inquiry',
                'content' => 'I would like to know more about your products.',
                'status' => ContactMessage::STATUS_NEW,
                'category' => ContactMessage::CATEGORY_GENERAL,
                'extra_data' => json_encode([
                    'responses' => [],
                ]),
                'last_update_time' => now(),
            ],
            [
                'customer_id' => 2,
                'content_key' => 'Technical Support',
                'content' => 'I need help with installation.',
                'status' => ContactMessage::STATUS_IN_PROGRESS,
                'category' => ContactMessage::CATEGORY_INSTALLATION,
                'admin_id' => 1,
                'extra_data' => json_encode([
                    'responses' => [
                        [
                            'message' => 'I will help you with the installation.',
                            'admin_id' => 1,
                            'created_at' => now()->toDateTimeString(),
                        ],
                    ],
                ]),
                'last_update_time' => now(),
            ],
        ];

        foreach ($messages as $message) {
            ContactMessage::create($message);
        }

        // Create landing page sections
        $sections = [
            [
                'name' => 'hero',
                'title' => 'Welcome to Our Website',
                'description' => 'Your trusted partner in quality products and services.',
                'content' => 'Discover our wide range of products and exceptional customer service.',
                'button_text' => 'Learn More',
                'button_link' => '#about',
                'is_active' => true,
                'show_order' => 1,
            ],
            [
                'name' => 'about',
                'title' => 'About Us',
                'description' => 'Who we are and what we do',
                'content' => 'We are a dedicated team committed to providing the best products and services to our customers.',
                'is_active' => true,
                'show_order' => 2,
            ],
            [
                'name' => 'services',
                'title' => 'Our Services',
                'description' => 'What we offer',
                'content' => 'We provide a wide range of services to meet your needs.',
                'is_active' => true,
                'show_order' => 3,
            ],
            [
                'name' => 'contact',
                'title' => 'Contact Us',
                'description' => 'Get in touch with us',
                'content' => 'We\'d love to hear from you. Send us a message!',
                'is_active' => true,
                'show_order' => 4,
            ],
        ];

        foreach ($sections as $section) {
            $sectionModel = Section::create($section);

            // Add section-specific content
            if ($section['name'] === 'services') {
                $services = [
                    [
                        'content_key' => 'service-1',
                        'content_value' => 'Product Sales',
                        'type' => 'service',
                        'show_order' => 1,
                        'extra_data' => json_encode([
                            'icon' => 'shopping-cart',
                            'description' => 'Quality products at competitive prices.',
                        ]),
                    ],
                    [
                        'content_key' => 'service-2',
                        'content_value' => 'Installation',
                        'type' => 'service',
                        'show_order' => 2,
                        'extra_data' => json_encode([
                            'icon' => 'tools',
                            'description' => 'Professional installation services.',
                        ]),
                    ],
                    [
                        'content_key' => 'service-3',
                        'content_value' => 'Support',
                        'type' => 'service',
                        'show_order' => 3,
                        'extra_data' => json_encode([
                            'icon' => 'headset',
                            'description' => '24/7 customer support.',
                        ]),
                    ],
                ];

                foreach ($services as $service) {
                    $sectionModel->contents()->create($service);
                }
            }
        }
    }
}
