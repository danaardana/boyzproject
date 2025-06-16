<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminNotification;
use App\Models\Admin;

class AdminNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin for testing
        $admin = Admin::first();
        
        if (!$admin) {
            $this->command->warn('No admin users found. Please create an admin user first.');
            return;
        }

        // Create sample notifications
        $notifications = [
            [
                'type' => 'login',
                'title' => 'Admin Login',
                'message' => $admin->name . ' logged into the admin panel.',
                'icon' => 'bx bx-log-in',
                'color' => 'info',
                'action_type' => 'admin',
                'user_id' => $admin->id,
                'user_name' => $admin->name,
                'user_email' => $admin->email,
                'is_read' => false,
                'created_at' => now()->subMinutes(5),
            ],
            [
                'type' => 'create',
                'title' => 'Section Content Created',
                'message' => $admin->name . ' created a new section content: Portfolio Item.',
                'icon' => 'bx bx-plus-circle',
                'color' => 'success',
                'action_type' => 'section_content',
                'action_id' => 1,
                'user_id' => $admin->id,
                'user_name' => $admin->name,
                'user_email' => $admin->email,
                'metadata' => json_encode([
                    'section_type' => 'portfolio',
                    'content_title' => 'New Portfolio Item'
                ]),
                'is_read' => false,
                'created_at' => now()->subMinutes(10),
            ],
            [
                'type' => 'update',
                'title' => 'Section Content Updated',
                'message' => $admin->name . ' updated section content: Testimonial Item.',
                'icon' => 'bx bx-edit-alt',
                'color' => 'warning',
                'action_type' => 'section_content',
                'action_id' => 2,
                'user_id' => $admin->id,
                'user_name' => $admin->name,
                'user_email' => $admin->email,
                'metadata' => json_encode([
                    'section_type' => 'testimonials',
                    'content_title' => 'Customer Testimonial'
                ]),
                'is_read' => true,
                'read_at' => now()->subMinutes(8),
                'created_at' => now()->subMinutes(15),
            ],
            [
                'type' => 'delete',
                'title' => 'Section Content Deleted',
                'message' => $admin->name . ' deleted section content: Old Instagram Post.',
                'icon' => 'bx bx-trash',
                'color' => 'danger',
                'action_type' => 'section_content',
                'user_id' => $admin->id,
                'user_name' => $admin->name,
                'user_email' => $admin->email,
                'metadata' => json_encode([
                    'item_name' => 'Old Instagram Post',
                    'section_type' => 'instagram'
                ]),
                'is_read' => false,
                'created_at' => now()->subMinutes(20),
            ],
            [
                'type' => 'create',
                'title' => 'Admin User Created',
                'message' => $admin->name . ' created a new admin user account.',
                'icon' => 'bx bx-user-plus',
                'color' => 'success',
                'action_type' => 'admin',
                'action_id' => 2,
                'user_id' => $admin->id,
                'user_name' => $admin->name,
                'user_email' => $admin->email,
                'metadata' => json_encode([
                    'new_admin_email' => 'newadmin@example.com'
                ]),
                'is_read' => false,
                'created_at' => now()->subHour(),
            ],
            [
                'type' => 'system',
                'title' => 'System Maintenance',
                'message' => 'System maintenance completed successfully.',
                'icon' => 'bx bx-cog',
                'color' => 'dark',
                'action_type' => 'system',
                'user_id' => null,
                'user_name' => 'System',
                'user_email' => null,
                'is_read' => true,
                'read_at' => now()->subHour(2),
                'created_at' => now()->subHours(3),
            ],
            [
                'type' => 'warning',
                'title' => 'Security Alert',
                'message' => 'Multiple failed login attempts detected.',
                'icon' => 'bx bx-error-circle',
                'color' => 'warning',
                'action_type' => 'security',
                'user_id' => null,
                'user_name' => 'Security System',
                'user_email' => null,
                'metadata' => json_encode([
                    'ip_address' => '192.168.1.100',
                    'attempts' => 5
                ]),
                'is_read' => false,
                'created_at' => now()->subHours(6),
            ],
        ];

        foreach ($notifications as $notification) {
            AdminNotification::create($notification);
        }

        $this->command->info('Sample admin notifications created successfully!');
    }
}
