<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ContactMessage;
use App\Models\Notification;

class AdminViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share data with admin views
        View::composer(['admin.partials.navbar', 'admin.*'], function ($view) {
            // Contact Messages for the existing messages dropdown
            $unreadMessages = ContactMessage::where('is_read', false)->count();
            $recentMessages = ContactMessage::with('customer')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Unified Notifications (all types in one table)
            $unreadNotifications = Notification::unread()->count();
            $recentNotifications = Notification::recent(10)->get();

            // Separate counts by user type for analytics if needed
            $unreadAdminNotifications = Notification::unread()->byUserType('admin')->count();
            $unreadCustomerNotifications = Notification::unread()->byUserType('customer')->count();
            $unreadSystemNotifications = Notification::unread()->byUserType('system')->count();

            $view->with([
                // Contact Messages (existing)
                'unreadMessages' => $unreadMessages,
                'recentMessages' => $recentMessages,
                
                // Unified Notifications
                'unreadNotifications' => $unreadNotifications,
                'recentNotifications' => $recentNotifications,
                
                // Breakdown by user type for dashboard analytics
                'unreadAdminNotifications' => $unreadAdminNotifications,
                'unreadCustomerNotifications' => $unreadCustomerNotifications,
                'unreadSystemNotifications' => $unreadSystemNotifications,
            ]);
        });
    }
} 