<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class CustomLanguageServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Get language from query parameter or session
        $lang = request()->get('lang', Session::get('lang', 'us'));
        
        // Only allow supported languages
        if (!in_array($lang, ['us', 'id'])) {
            $lang = 'us';
        }

        // Store language in session
        Session::put('lang', $lang);

        // Load language file from public/admin/lang
        $langFile = public_path("admin/lang/{$lang}.php");
        if (file_exists($langFile)) {
            require_once $langFile;
            
            // Make language array available globally
            view()->share('language', $language ?? []);
        }
    }
} 