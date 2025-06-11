<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Check if this is an admin route request
            if ($request->is('admin*') || $request->is('api/admin*')) {
                // Always redirect admin routes to admin login
                return route('admin.login');
            }
            
            // For regular web routes, try to redirect to login or landing page
            if (\Illuminate\Support\Facades\Route::has('login')) {
                return route('login');
            }
            
            // Fallback to landing page
            return route('landing-page');
        }
        return null;
    }
} 