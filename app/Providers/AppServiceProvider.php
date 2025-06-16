<?php

namespace App\Providers;
use Illuminate\Support\Facades\URL;


use Illuminate\Support\ServiceProvider;
use App\Observers\NotificationObserver;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\ChatMessage;
use App\Models\ChatConversation;
use App\Models\ContactMessage;
use App\Models\Section;
use App\Models\SectionContent;
use App\Models\Product;
use App\Models\MLResponse;
use App\Models\ChatbotAutoResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        } else {
            URL::forceScheme('http');
        }

        header("X-Frame-Options: ALLOWALL");

        // Register NotificationObserver for models that need notification tracking
        Admin::observe(NotificationObserver::class);
        Customer::observe(NotificationObserver::class);
        ChatMessage::observe(NotificationObserver::class);
        ChatConversation::observe(NotificationObserver::class);
        ContactMessage::observe(NotificationObserver::class);
        Section::observe(NotificationObserver::class);
        SectionContent::observe(NotificationObserver::class);
        Product::observe(NotificationObserver::class);
        MLResponse::observe(NotificationObserver::class);
        ChatbotAutoResponse::observe(NotificationObserver::class);
    }
}
