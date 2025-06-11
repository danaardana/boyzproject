<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Providers\EncryptedUserProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Model::class => ModelPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Register custom encrypted user provider
        Auth::provider('encrypted_eloquent', function ($app, array $config) {
            return new EncryptedUserProvider($app['hash'], $config['model']);
        });

        // Define a super admin gate
        Gate::define('super-admin', function ($user) {
            return $user->role === 'super-admin';
        });

        // Define an admin gate
        Gate::define('admin', function ($user) {
            return in_array($user->role, ['admin', 'super-admin']);
        });
    }
} 