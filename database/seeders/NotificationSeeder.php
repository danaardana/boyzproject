<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\Admin;
use App\Models\Customer;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first admin and customer for testing (if they exist)
        $admin = Admin::first();
        $customer = Customer::first();
        
        // Create sample notifications
        $notifications = [
            // System notifications
            [
                'type' => 'system',
                'title' => 'System Backup Completed',
                'message' => 'Daily system backup has been completed successfully.',
                'icon' => 'bx bx-check-circle',
                'color' => 'success',
                'action_type' => 'system',
                'user_type' => 'system',
                'user_name' => 'System',
                'is_read' => false,
                'created_at' => now()->subHours(2),
            ],
            [
                'type' => 'system',
                'title' => 'Database Maintenance',
                'message' => 'Scheduled database maintenance will occur at 2:00 AM.',
                'icon' => 'bx bx-wrench',
                'color' => 'warning',
                'action_type' => 'maintenance',
                'user_type' => 'system',
                'user_name' => 'System',
                'is_read' => false,
                'created_at' => now()->subHours(6),
            ],
            
            // Admin notifications (if admin exists)
            ...$admin ? [
                [
                    'type' => 'login',
                    'title' => 'Admin Login',
                    'message' => $admin->name . ' logged into the admin panel.',
                    'icon' => 'bx bx-log-in',
                    'color' => 'info',
                    'action_type' => 'admin',
                    'user_id' => $admin->id,
                    'user_type' => 'admin',
                    'user_name' => $admin->name,
                    'user_email' => $admin->email,
                    'metadata' => [
                        'ip_address' => '192.168.1.100',
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                    ],
                    'is_read' => false,
                    'created_at' => now()->subMinutes(30),
                ],
                [
                    'type' => 'create',
                    'title' => 'New Admin User Created',
                    'message' => $admin->name . ' created a new admin user account.',
                    'icon' => 'bx bx-user-plus',
                    'color' => 'success',
                    'action_type' => 'admin',
                    'action_id' => $admin->id,
                    'action_model' => 'App\\Models\\Admin',
                    'user_id' => $admin->id,
                    'user_type' => 'admin',
                    'user_name' => $admin->name,
                    'user_email' => $admin->email,
                    'metadata' => [
                        'created_admin_email' => 'newadmin@example.com'
                    ],
                    'is_read' => true,
                    'read_at' => now()->subMinutes(20),
                    'created_at' => now()->subMinutes(45),
                ],
            ] : [],
            
            // Customer notifications (if customer exists)
            ...$customer ? [
                [
                    'type' => 'create',
                    'title' => 'New Customer Registration',
                    'message' => 'New customer ' . $customer->name . ' has registered.',
                    'icon' => 'bx bx-user-plus',
                    'color' => 'success',
                    'action_type' => 'customer',
                    'action_id' => $customer->id,
                    'action_model' => 'App\\Models\\Customer',
                    'user_id' => $customer->id,
                    'user_type' => 'customer',
                    'user_name' => $customer->name,
                    'user_email' => $customer->email,
                    'metadata' => [
                        'registration_ip' => '192.168.1.150',
                        'source' => 'web'
                    ],
                    'is_read' => false,
                    'created_at' => now()->subHours(4),
                ],
                [
                    'type' => 'update',
                    'title' => 'Customer Profile Updated',
                    'message' => 'Customer ' . $customer->name . ' updated their profile information.',
                    'icon' => 'bx bx-edit-alt',
                    'color' => 'warning',
                    'action_type' => 'customer',
                    'action_id' => $customer->id,
                    'action_model' => 'App\\Models\\Customer',
                    'user_id' => $customer->id,
                    'user_type' => 'customer',
                    'user_name' => $customer->name,
                    'user_email' => $customer->email,
                    'metadata' => [
                        'fields_updated' => ['phone', 'address']
                    ],
                    'is_read' => false,
                    'created_at' => now()->subHours(8),
                ],
            ] : [],
            
            // General application notifications
            [
                'type' => 'info',
                'title' => 'New Feature Available',
                'message' => 'A new chatbot feature has been deployed and is now available.',
                'icon' => 'bx bx-info-circle',
                'color' => 'info',
                'action_type' => 'feature',
                'user_type' => 'system',
                'user_name' => 'System',
                'metadata' => [
                    'feature_name' => 'Enhanced Chatbot',
                    'version' => '2.1.0'
                ],
                'is_read' => false,
                'created_at' => now()->subDays(1),
            ],
            [
                'type' => 'warning',
                'title' => 'High Server Load',
                'message' => 'Server load is higher than normal. Monitoring system performance.',
                'icon' => 'bx bx-error-circle',
                'color' => 'warning',
                'action_type' => 'performance',
                'user_type' => 'system',
                'user_name' => 'Monitoring System',
                'metadata' => [
                    'cpu_usage' => '85%',
                    'memory_usage' => '78%'
                ],
                'is_read' => true,
                'read_at' => now()->subHours(12),
                'created_at' => now()->subDays(2),
            ],
            [
                'type' => 'success',
                'title' => 'Security Update Applied',
                'message' => 'Security patches have been successfully applied to the system.',
                'icon' => 'bx bx-shield-check',
                'color' => 'success',
                'action_type' => 'security',
                'user_type' => 'system',
                'user_name' => 'Security System',
                'metadata' => [
                    'patches_applied' => 3,
                    'security_level' => 'high'
                ],
                'is_read' => false,
                'created_at' => now()->subDays(3),
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }

        $this->command->info('Sample notifications created successfully!');
        $this->command->info('Total notifications created: ' . count($notifications));
    }
} 