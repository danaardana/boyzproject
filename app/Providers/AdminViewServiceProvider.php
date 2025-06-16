<?php

namespace App\Providers;

use App\Models\ContactMessage;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Share unread messages count and recent messages with admin views
        View::composer('admin.*', function ($view) {
            $unreadMessages = ContactMessage::unread()->count();
            $recentMessages = ContactMessage::latest()
                ->take(5)
                ->get();
                
            // Add notification data
            $unreadNotifications = AdminNotification::getUnreadCount();
            $recentNotifications = AdminNotification::getRecentNotifications(10);
                
            $view->with([
                'unreadMessages' => $unreadMessages,
                'recentMessages' => $recentMessages,
                'unreadNotifications' => $unreadNotifications,
                'recentNotifications' => $recentNotifications,
            ]);
        });
    }
} 