<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Public routes
Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Force logout route (accessible even if middleware fails)
Route::get('/admin/force-logout', function() {
    Auth::guard('admin')->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('admin.login')->with('status', 'You have been logged out successfully.');
})->name('admin.force-logout');

// Admin verification route (public for email verification)
Route::get('/admin/verify/{id}/{token}', [EmailController::class, 'verifyAdmin'])->name('admin.verify');

// Admin reactivation route (public for email reactivation)
Route::get('/admin/reactivate/{id}/{token}', [EmailController::class, 'reactivateAdmin'])->name('admin.reactivate');

// Test route for email functionality (remove after testing)
Route::get('/test-email/{adminId}', function($adminId) {
    $admin = \App\Models\Admin::findOrFail($adminId);
    $securityCode = $admin->generateSecurityCode();
    
    try {
        \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\AdminSecurityCode($admin, $securityCode));
        return "Security code email sent successfully to {$admin->email}! Code: {$securityCode}";
    } catch (\Exception $e) {
        return "Failed to send email: " . $e->getMessage();
    }
})->name('test.email');

// Test welcome email route
Route::get('/test-welcome-email/{adminId}', function($adminId) {
    $admin = \App\Models\Admin::findOrFail($adminId);
    $testPassword = 'TempPass123!';
    $verificationUrl = route('admin.login');
    
    try {
        \Illuminate\Support\Facades\Mail::to($admin->email)
            ->send(new \App\Mail\AdminWelcomeEmail($admin, $testPassword, $verificationUrl));
        return "Welcome email sent successfully to {$admin->email}!";
    } catch (\Exception $e) {
        return "Failed to send welcome email: " . $e->getMessage();
    }
})->name('test.welcome.email');

// Admin Auth Routes
Route::prefix('admin')->group(function () {
    // Guest routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
        
        // Password Reset Routes
        Route::get('/password/reset', [AuthController::class, 'showForgotForm'])->name('admin.password.request');
        Route::post('/password/email', [AuthController::class, 'sendResetCode'])->name('admin.password.email');
        Route::get('/password/reset/form', [AuthController::class, 'showResetForm'])->name('admin.password.reset');
        Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('admin.password.update');
    });

    // Protected routes - Use full class path to avoid middleware resolution issues
    Route::middleware(['auth:admin', \App\Http\Middleware\PreventBackHistory::class, \App\Http\Middleware\AdminVerificationMiddleware::class])->group(function () {
        // Dashboard and main features
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        
        // Session check route (for AJAX calls)
        Route::get('/auth-check', function() {
            return response()->json(['authenticated' => true]);
        })->name('admin.auth.check');
        
        // Messages routes
        Route::get('/messages', [ContactController::class, 'index'])->name('admin.messages.index');
        Route::get('/messages/{message}', [ContactController::class, 'show'])->name('admin.messages.show');
        Route::post('/messages/{message}/read', [ContactController::class, 'markAsRead'])->name('admin.messages.mark-read');
        Route::post('/messages/{message}/assign', [ContactController::class, 'assign'])->name('admin.messages.assign');
        Route::post('/messages/{message}/respond', [ContactController::class, 'respond'])->name('admin.messages.respond');
        Route::delete('/messages/{message}', [ContactController::class, 'destroy'])->name('admin.messages.destroy');
        Route::post('/messages/read-all', [ContactController::class, 'markAllAsRead'])->name('admin.messages.mark-all-read');
        
        // Email routes
        Route::prefix('emails')->group(function () {
            Route::post('/reactivation', [EmailController::class, 'sendReactivationNotification'])->name('admin.emails.reactivation');
            Route::post('/security-code', [EmailController::class, 'sendSecurityCode'])->name('admin.emails.security-code');
            Route::post('/verification', [EmailController::class, 'sendVerification'])->name('admin.emails.verification');
            Route::post('/bulk', [EmailController::class, 'sendBulkEmails'])->name('admin.emails.bulk');
        });
        
        // Lockscreen routes
        Route::get('/lockscreen', [AuthController::class, 'lockscreen'])->name('admin.lockscreen');
        Route::post('/unlock', [AuthController::class, 'unlock'])->name('admin.unlock');
        
        // Password change routes
        Route::get('/password/change', [AuthController::class, 'showChangePasswordForm'])->name('admin.password.change');
        Route::post('/password/change', [AuthController::class, 'changePassword'])->name('admin.password.change.submit');
        
        // Content management routes
        Route::get('/landingpage-tables', [AdminController::class, 'landingPageTables'])->name('admin.landingPageTables');
        Route::get('/subsection-tables', [AdminController::class, 'subsectionTables'])->name('admin.subsectionTables');
        Route::get('/subsections/{id}', [AdminController::class, 'subsectionTables'])->name('admin.subsection_tables');

        // Table routes
        Route::get('/portofolio', [TableController::class, 'show'])->defaults('type', 'portofolio')->name('admin.portofolio');
        Route::get('/instagram', [TableController::class, 'show'])->defaults('type', 'instagram')->name('admin.instagram');
        Route::get('/tiktok', [TableController::class, 'show'])->defaults('type', 'tiktok')->name('admin.tiktok');
        Route::get('/testimonials', [TableController::class, 'show'])->defaults('type', 'testimonials')->name('admin.testimonials');
        Route::get('/promotion', [TableController::class, 'show'])->defaults('type', 'promotion')->name('admin.promotion');
        Route::get('/categories', [TableController::class, 'show'])->defaults('type', 'categories')->name('admin.categories');
        
        // Content update routes
        Route::put('/section-content/{id}', [AdminController::class, 'update'])->name('section_content.update');
        
        // Other admin features
        Route::get('/faq', [AdminController::class, 'faqPage'])->name('admin.faq');
        Route::get('/chat', [ContactController::class, 'index'])->name('admin.chat');
        Route::get('/admin', [AdminController::class, 'adminPage'])->name('admin.admin');
        Route::get('/history', [AdminController::class, 'historyPage'])->name('admin.history');
        
        // Session Management Routes
        Route::get('/admin-login-history/{adminId?}', [AdminController::class, 'adminLoginHistory'])->name('admin.login-history');
        Route::post('/clean-old-sessions', [AdminController::class, 'cleanOldSessions'])->name('admin.clean-sessions');
        
        // Admin Management Routes
        Route::prefix('admins')->group(function () {
            Route::post('/', [AdminController::class, 'storeAdmin'])->name('admin.admins.store');
            Route::post('/{admin}/verify', [AdminController::class, 'verifyAdmin'])->name('admin.admins.verify');
            Route::post('/{admin}/activate', [AdminController::class, 'activateAdmin'])->name('admin.admins.activate');
            Route::post('/{admin}/deactivate', [AdminController::class, 'deactivateAdmin'])->name('admin.admins.deactivate');
            Route::delete('/{admin}', [AdminController::class, 'deleteAdmin'])->name('admin.admins.destroy');
        });
        Route::post('/check-email', [AdminController::class, 'checkEmailAvailability'])->name('admin.check-email');
        
        Route::get('/email-verification/{email}', [AdminController::class, 'emailVerification'])->name('admin.email-verification');
        Route::get('/email-confirmation', [AdminController::class, 'emailConfirmation'])->name('admin.email-confirmation');
        Route::post('/verify-email', [EmailVerificationController::class, 'verify'])->name('verify.email.submit');
    });
});