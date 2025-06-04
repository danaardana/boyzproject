<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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