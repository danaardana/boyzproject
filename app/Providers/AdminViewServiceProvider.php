<?php

namespace App\Providers;

use App\Models\ContactMessage;
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
                
            $view->with([
                'unreadMessages' => $unreadMessages,
                'recentMessages' => $recentMessages,
            ]);
        });
    }
} 