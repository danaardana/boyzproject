<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get language from query parameter or session
        $lang = $request->query('lang', Session::get('lang', 'us'));
        
        // Only allow supported languages
        if (!in_array($lang, ['us', 'id'])) {
            $lang = 'us';
        }

        // Store language in session
        Session::put('lang', $lang);

        // Load language file from public/admin/lang
        $langFile = public_path("admin/lang/{$lang}.php");
        if (file_exists($langFile)) {
            $GLOBALS['language'] = require $langFile;
        } else {
            $GLOBALS['language'] = require public_path('admin/lang/us.php');
        }

        return $next($request);
    }
} 