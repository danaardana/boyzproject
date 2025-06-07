<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Throwable;

class DatabaseSessionFallback
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Only check for admin routes
        if ($request->is('admin') || $request->is('admin/*')) {
            // Test database connection before session starts
            if (!$this->isDatabaseConnected()) {
                // Switch to file session driver temporarily
                Config::set('session.driver', 'file');
                
                // Also handle the request as database error
                return $this->handleDatabaseError($request);
            }
        }
        
        return $next($request);
    }
    
    /**
     * Test if database connection is available
     */
    protected function isDatabaseConnected(): bool
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (Throwable $e) {
            return false;
        }
    }
    
    /**
     * Handle database connection error
     */
    protected function handleDatabaseError(Request $request)
    {
        // If it's an AJAX request, return JSON response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'error' => 'db_error',
                'message' => 'Database connection error. Please try again later.',
            ], 503);
        }
        
        // Check if this is an admin route
        if ($request->is('admin') || $request->is('admin/*')) {
            // Return custom admin error page
            return response()->view('admin.page-error', [
                'errorCode' => 'db_error',
                'exception' => new \Exception('Database connection failed'),
            ], 503);
        } else {
            // For non-admin routes, use the error-page template
            return response()->view('errors.error-page', [
                'errorCode' => 'db_error',
                'exception' => new \Exception('Database connection failed'),
            ], 503);
        }
    }
} 