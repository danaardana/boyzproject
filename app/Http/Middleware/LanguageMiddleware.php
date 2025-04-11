<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    public function handle($request, Closure $next)
    {
        // Cek apakah ada parameter 'lang' dalam request
        if ($request->has('lang')) {
            $lang = $request->get('lang');
            App::setLocale($lang);
            Session::put('locale', $lang);
        } elseif (Session::has('locale')) {
            // Jika tidak ada, gunakan locale dari session jika tersedia
            App::setLocale(Session::get('locale'));
        }

        return $next($request);
    }
}
