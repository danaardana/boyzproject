<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Pastikan Laravel berjalan di HTTPS (opsional)
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        // Pastikan iframe TikTok dan Instagram bisa dimuat
        header("X-Frame-Options: ALLOWALL");
    }
}
