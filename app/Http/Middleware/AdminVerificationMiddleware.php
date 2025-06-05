<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip verification check for certain routes
        $skipRoutes = [
            'admin.login',
            'admin.login.submit',
            'admin.logout',
            'admin.password.request',
            'admin.password.email',
            'admin.password.reset',
            'admin.password.update',
            'admin.email-verification',
            'admin.verify',
            'verify.email.submit'
        ];

        if (in_array($request->route()->getName(), $skipRoutes)) {
            return $next($request);
        }

        // Check if admin is authenticated
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $admin = Auth::guard('admin')->user();

        // Check if admin is verified
        if (!$admin->verified) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Your account is not verified. Please check your email for verification instructions.',
            ]);
        }

        // Check if admin is active
        if (!$admin->is_active) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Your account has been deactivated. Please contact the system administrator.',
            ]);
        }

        return $next($request);
    }
}
