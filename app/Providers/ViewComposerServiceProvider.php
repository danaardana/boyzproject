<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ContactMessage;

class ViewComposerServiceProvider extends ServiceProvider
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
        // Share unread messages count and recent messages with all admin views
        View::composer('admin.partials.navbar', function ($view) {
            $unreadMessages = ContactMessage::where('is_read', false)->count();
            $recentMessages = ContactMessage::with('customer')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $view->with([
                'unreadMessages' => $unreadMessages,
                'recentMessages' => $recentMessages
            ]);
        });
    }
} 