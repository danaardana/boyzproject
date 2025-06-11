<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Session\SessionManager;
use Illuminate\Session\SessionServiceProvider as BaseSessionServiceProvider;

class CustomSessionServiceProvider extends BaseSessionServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Call parent registration first to ensure all session services are registered
        parent::register();
        
        // Override the session manager with our custom one
        $this->app->singleton('session', function ($app) {
            return new CustomSessionManager($app);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // SessionServiceProvider doesn't have a boot method
    }
}

class CustomSessionManager extends SessionManager
{
    /**
     * Get the session configuration.
     */
    protected function getConfig($name)
    {
        $config = parent::getConfig($name);
        
        // If the driver is database, check if database is available
        if ($config['driver'] === 'database' && !$this->isDatabaseConnected()) {
            // Fall back to file driver
            $config['driver'] = 'file';
            
            // Log the fallback for debugging
            \Log::warning('Database unavailable for sessions, falling back to file driver');
        }
        
        return $config;
    }
    
    /**
     * Check if database connection is available
     */
    protected function isDatabaseConnected(): bool
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
} 