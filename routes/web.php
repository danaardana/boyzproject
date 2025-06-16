<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\SectionController;
// use App\Http\Controllers\Admin\AdminUserController; // Commented out - controller doesn't exist
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\ChatbotController;
use App\Http\Controllers\Admin\MLResponseController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\DocumentationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;

// Public routes
Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/privacy', [LandingPageController::class, 'privacy'])->name('landing.privacy');
Route::get('/terms', [LandingPageController::class, 'terms'])->name('landing.terms');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

        // Route::resource('users', AdminUserController::class)->names('admin.users'); // Controller doesn't exist

// Define a regular 'login' route that redirects to admin login (for fallback)
Route::get('/login', function() {
    return redirect()->route('admin.login');
})->name('login');

// Public Chat Routes (for landing page chat to admin)
Route::prefix('chat')->group(function () {
    Route::post('/start', [App\Http\Controllers\Admin\ChatController::class, 'startConversationFromLanding'])->name('public.chat.start');
    Route::post('/check-customer', [App\Http\Controllers\Admin\ChatController::class, 'checkCustomerByPhone'])->name('public.chat.check-customer');
    Route::post('/{conversation}/reply', [App\Http\Controllers\Admin\ChatController::class, 'sendReplyFromLanding'])->name('public.chat.reply');
    Route::get('/{conversation}/messages', [App\Http\Controllers\Admin\ChatController::class, 'getConversationMessages'])->name('public.chat.messages');
    Route::post('/get-auto-response', [App\Http\Controllers\Admin\ChatbotController::class, 'getAutoResponse'])->name('public.chat.get-auto-response');
});

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

// Test email route - REMOVE AFTER TESTING
Route::get('/test-email', function() {
    try {
        // Test basic mail configuration
        $customer = App\Models\Customer::first();
        if (!$customer) {
            return response()->json(['error' => 'No customer found for testing']);
        }

        $admin = App\Models\Admin::first();
        if (!$admin) {
            return response()->json(['error' => 'No admin found for testing']);
        }

        // Create a test message
        $testMessage = App\Models\ContactMessage::first();
        if (!$testMessage) {
            return response()->json(['error' => 'No contact message found for testing']);
        }

        // Get mail configuration info
        $mailConfig = [
            'mailer' => config('mail.default'),
            'driver' => config('mail.mailers.' . config('mail.default') . '.transport'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'from_address' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
        ];

        // Try to send a test email
        try {
            Mail::to($customer->email)->send(
                new \App\Mail\MessageReplyMail(
                    $customer,
                    'This is a test email to verify mail functionality.',
                    $testMessage,
                    'resolved',
                    $admin->name
                )
            );
            
            $emailStatus = 'Email sent successfully!';
        } catch (\Exception $mailError) {
            $emailStatus = 'Email failed: ' . $mailError->getMessage();
        }

        return response()->json([
            'mail_config' => $mailConfig,
            'email_status' => $emailStatus,
            'customer_email' => $customer->email,
            'admin_name' => $admin->name
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});

// Debug route to check stats
Route::get('/debug-stats', function() {
    $stats = [
        'total' => \App\Models\ChatbotAutoResponse::count(),
        'active' => \App\Models\ChatbotAutoResponse::where('is_active', true)->count(),
        'inactive' => \App\Models\ChatbotAutoResponse::where('is_active', false)->count(),
        'high_priority' => \App\Models\ChatbotAutoResponse::where('priority', '>=', 100)->count(),
    ];
    
    return response()->json([
        'stats' => $stats,
        'raw_data' => \App\Models\ChatbotAutoResponse::select('is_active', 'priority')->get()
    ]);
});

// Public API routes for chat functionality
Route::post('/api/chatbot/auto-response', [App\Http\Controllers\Admin\ChatbotController::class, 'getAutoResponse'])
    ->name('api.chatbot.auto-response');

Route::post('/api/chatbot/intelligent-response', [App\Http\Controllers\Admin\ChatbotController::class, 'getIntelligentResponse'])
    ->name('api.chatbot.intelligent-response');

// Public chat routes for landing page
Route::post('/chat/get-auto-response', [App\Http\Controllers\ContactController::class, 'getAutoResponse'])
    ->name('chat.auto-response');

Route::post('/chat/get-intelligent-response', [App\Http\Controllers\ContactController::class, 'getIntelligentResponse'])
    ->name('chat.intelligent-response');

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

    // Lockscreen routes - Only need auth:admin middleware, not verification middleware
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/lockscreen', [AuthController::class, 'lockscreen'])->name('admin.lockscreen');
    });
    
    // Unlock route - Needs web middleware for CSRF and session handling, but no auth since admin is logged out
    Route::middleware(['web'])->group(function () {
        Route::post('/unlock', [AuthController::class, 'unlock'])->name('admin.unlock');
    });

    // Protected routes - Use full class path to avoid middleware resolution issues
    Route::middleware(['auth:admin', \App\Http\Middleware\PreventBackHistory::class, \App\Http\Middleware\AdminVerificationMiddleware::class])->group(function () {
        // Dashboard and main features
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        
        // Session check route (for AJAX calls)
        Route::get('/auth-check', function() {
            return response()->json(['authenticated' => true]);
        })->name('admin.auth.check');
        
        // Session validation route (for cross-tab logout detection)
        Route::get('/session-check', function() {
            if (!Auth::guard('admin')->check()) {
                return response()->json(['authenticated' => false, 'redirect' => route('admin.login')], 401);
            }
            return response()->json(['authenticated' => true]);
        
        })->name('admin.session.check');
        
        // Messages routes
        Route::get('/messages', [ContactController::class, 'index'])->name('admin.messages.index');
        Route::get('/messages/{message}', [ContactController::class, 'show'])->name('admin.messages.show');
        Route::get('/sent/{response}', [ContactController::class, 'showSentMessage'])->name('admin.messages.sent.show');
        Route::post('/messages/{message}/read', [ContactController::class, 'markAsRead'])->name('admin.messages.mark-read');
        Route::post('/messages/{message}/assign', [ContactController::class, 'assign'])->name('admin.messages.assign');
        Route::post('/messages/{message}/respond', [ContactController::class, 'respond'])->name('admin.messages.respond');
        Route::post('/messages/{message}/important', [ContactController::class, 'toggleImportant'])->name('admin.messages.toggle-important');
        Route::post('/messages/{message}/trash', [ContactController::class, 'moveToTrash'])->name('admin.messages.trash');
        Route::post('/messages/{message}/restore', [ContactController::class, 'restoreFromTrash'])->name('admin.messages.restore');
        Route::delete('/messages/{message}', [ContactController::class, 'destroy'])->name('admin.messages.destroy');
        Route::delete('/messages/{message}/permanent', [ContactController::class, 'permanentDelete'])->name('admin.messages.permanent-delete');
        Route::post('/messages/read-all', [ContactController::class, 'markAllAsRead'])->name('admin.messages.mark-all-read');
        
        // Real-time message notifications API
        Route::get('/api/messages/notifications', [ContactController::class, 'getMessageNotifications'])->name('admin.api.messages.notifications');
        
        // Email routes
        Route::prefix('emails')->group(function () {
            Route::post('/reactivation', [EmailController::class, 'sendReactivationNotification'])->name('admin.emails.reactivation');
            Route::post('/security-code', [EmailController::class, 'sendSecurityCode'])->name('admin.emails.security-code');
            Route::post('/verification', [EmailController::class, 'sendVerification'])->name('admin.emails.verification');
            Route::post('/bulk', [EmailController::class, 'sendBulkEmails'])->name('admin.emails.bulk');
        });
        

        
        // Password change routes
        Route::get('/password/change', [AuthController::class, 'showChangePasswordForm'])->name('admin.password.change');
        Route::post('/password/change', [AuthController::class, 'changePassword'])->name('admin.password.change.submit');
        
        // Content management routes
        Route::get('/landingpage-tables', [AdminController::class, 'landingPageTables'])->name('admin.landingPageTables');
        Route::get('/subsection-tables', [AdminController::class, 'subsectionTables'])->name('admin.subsectionTables');
        Route::get('/subsections/{id}', [AdminController::class, 'subsectionTables'])->name('admin.subsection_tables');
        Route::get('/products-tables', [AdminController::class, 'productsTables'])->name('admin.productsTables');

        // Table routes
        Route::get('/portofolio', [TableController::class, 'show'])->defaults('type', 'portofolio')->name('admin.portofolio');
        Route::get('/instagram', [TableController::class, 'show'])->defaults('type', 'instagram')->name('admin.instagram');
        Route::get('/tiktok', [TableController::class, 'show'])->defaults('type', 'tiktok')->name('admin.tiktok');
        Route::get('/testimonials', [TableController::class, 'show'])->defaults('type', 'testimonials')->name('admin.testimonials');
        Route::get('/promotion', [TableController::class, 'show'])->defaults('type', 'promotion')->name('admin.promotion');
        Route::get('/categories', [TableController::class, 'show'])->defaults('type', 'categories')->name('admin.categories');
        
        // CRUD routes for section content
        Route::prefix('section-content')->group(function () {
            Route::post('/', [TableController::class, 'store'])->name('admin.section-content.store');
            Route::get('/{id}/edit', [TableController::class, 'edit'])->name('admin.section-content.edit');
            Route::put('/{id}', [TableController::class, 'update'])->name('admin.section-content.update');
            Route::delete('/{id}', [TableController::class, 'destroy'])->name('admin.section-content.destroy');
        });
        
        // Notification routes
        Route::prefix('notifications')->group(function () {
            Route::get('/', [\App\Http\Controllers\NotificationController::class, 'getRecentNotifications'])->name('admin.notifications.recent');
            Route::post('/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('admin.notifications.mark-read');
            Route::post('/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('admin.notifications.mark-all-read');
            Route::delete('/remove-all', [\App\Http\Controllers\NotificationController::class, 'removeAll'])->name('admin.notifications.remove-all');
            Route::delete('/{id}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('admin.notifications.destroy');
            Route::get('/stats', [\App\Http\Controllers\NotificationController::class, 'getStats'])->name('admin.notifications.stats');
        });
        
        // Other admin features
        Route::get('/faq', [AdminController::class, 'faqPage'])->name('admin.faq');
        Route::get('/documentation', [AdminController::class, 'documentationPage'])->name('admin.documentation');
        
        // Documentation Routes
        Route::prefix('documentation')->group(function () {
            Route::get('/', [App\Http\Controllers\DocumentationController::class, 'index'])->name('admin.documentation.index');
            Route::get('/search', [App\Http\Controllers\DocumentationController::class, 'search'])->name('admin.documentation.search');
            Route::get('/{system}', [App\Http\Controllers\DocumentationController::class, 'show'])->name('admin.documentation.show');
            Route::get('/{system}/export', [App\Http\Controllers\DocumentationController::class, 'export'])->name('admin.documentation.export');
        });
        
        // Chat routes
        Route::get('/chat', [App\Http\Controllers\Admin\ChatController::class, 'index'])->name('admin.chat');
        Route::post('/chat/start', [App\Http\Controllers\Admin\ChatController::class, 'startConversation'])->name('admin.chat.start');
        Route::get('/chat/conversation/{conversationId}', [App\Http\Controllers\Admin\ChatController::class, 'getConversation'])->name('admin.chat.conversation');
        Route::post('/chat/conversation/{conversationId}/reply', [App\Http\Controllers\Admin\ChatController::class, 'sendReply'])->name('admin.chat.reply');
        Route::post('/chat/conversation/{conversationId}/transfer', [App\Http\Controllers\Admin\ChatController::class, 'transferConversation'])->name('admin.chat.transfer');
        Route::post('/chat/conversation/{conversationId}/resolve', [App\Http\Controllers\Admin\ChatController::class, 'resolveConversation'])->name('admin.chat.resolve');
        Route::get('/chat/stats', [App\Http\Controllers\Admin\ChatController::class, 'getStats'])->name('admin.chat.stats');
        
        // Chatbot Management routes
        Route::prefix('chatbot')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\ChatbotController::class, 'index'])->name('admin.chatbot');
            Route::get('/ml', [App\Http\Controllers\Admin\ChatbotController::class, 'mlManagement'])->name('admin.chatbot.ml');
            Route::get('/stats', [App\Http\Controllers\Admin\ChatbotController::class, 'getStats'])->name('admin.chatbot.stats');
            Route::get('/auto-responses', [App\Http\Controllers\Admin\ChatbotController::class, 'getAutoResponses'])->name('admin.chatbot.auto-responses');
            Route::post('/auto-responses', [App\Http\Controllers\Admin\ChatbotController::class, 'store'])->name('admin.chatbot.auto-responses.store');
            Route::get('/auto-responses/{id}', [App\Http\Controllers\Admin\ChatbotController::class, 'show'])->name('admin.chatbot.auto-responses.show');
            Route::put('/auto-responses/{id}', [App\Http\Controllers\Admin\ChatbotController::class, 'update'])->name('admin.chatbot.auto-responses.update');
            Route::delete('/auto-responses/{id}', [App\Http\Controllers\Admin\ChatbotController::class, 'destroy'])->name('admin.chatbot.auto-responses.destroy');
            Route::post('/auto-responses/{id}/toggle', [App\Http\Controllers\Admin\ChatbotController::class, 'toggleStatus'])->name('admin.chatbot.auto-responses.toggle');
            Route::post('/auto-responses/test', [App\Http\Controllers\Admin\ChatbotController::class, 'testResponse'])->name('admin.chatbot.auto-responses.test');
            Route::post('/auto-responses/bulk-delete', [App\Http\Controllers\Admin\ChatbotController::class, 'bulkDelete'])->name('admin.chatbot.auto-responses.bulk-delete');
            Route::get('/auto-responses/export/csv', [App\Http\Controllers\Admin\ChatbotController::class, 'export'])->name('admin.chatbot.auto-responses.export');
            
            // ML Model Integration routes
            Route::prefix('ml')->group(function () {
                Route::get('/test-python', [App\Http\Controllers\Admin\ChatbotController::class, 'testPythonInstallation'])->name('admin.chatbot.ml.test-python');
                Route::post('/predict', [App\Http\Controllers\Admin\ChatbotController::class, 'testMLPrediction'])->name('admin.chatbot.ml.predict');
                Route::get('/motor-compatibility', [App\Http\Controllers\Admin\ChatbotController::class, 'getMotorCompatibility'])->name('admin.chatbot.ml.motor-compatibility');
                Route::get('/product-compatibility', [App\Http\Controllers\Admin\ChatbotController::class, 'getProductCompatibility'])->name('admin.chatbot.ml.product-compatibility');
                Route::get('/response-dict', [App\Http\Controllers\Admin\ChatbotController::class, 'getMLResponseDict'])->name('admin.chatbot.ml.response-dict');
            });

            // ML Response Management routes
            Route::prefix('ml-responses')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\MLResponseController::class, 'index'])->name('admin.chatbot.ml-responses');
                Route::post('/', [App\Http\Controllers\Admin\MLResponseController::class, 'store'])->name('admin.chatbot.ml-responses.store');
                Route::put('/{id}', [App\Http\Controllers\Admin\MLResponseController::class, 'update'])->name('admin.chatbot.ml-responses.update');
                Route::delete('/{id}', [App\Http\Controllers\Admin\MLResponseController::class, 'destroy'])->name('admin.chatbot.ml-responses.destroy');
                Route::post('/{id}/toggle', [App\Http\Controllers\Admin\MLResponseController::class, 'toggleStatus'])->name('admin.chatbot.ml-responses.toggle');
                Route::post('/import', [App\Http\Controllers\Admin\MLResponseController::class, 'importFromPredictV2'])->name('admin.chatbot.ml-responses.import');
            });

            Route::resource('landing-pages', LandingPageController::class)->except(['index', 'show']);

            Route::get('/landing-pages', [LandingPageController::class, 'indexAdmin'])->name('admin.landing-pages.index'); 
            Route::resource('landing-pages', LandingPageController::class)->except(['index']); 

            // Section CRUD
            Route::resource('sections', SectionController::class)->names('admin.sections');


        });
        
        // Admin Management Routes
        Route::prefix('admins')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('admin.admins.index'); // Daftar admin
            Route::get('/create', [AdminController::class, 'create'])->name('admin.admins.create'); // Form tambah admin
            Route::post('/', [AdminController::class, 'storeAdmin'])->name('admin.admins.store'); // Simpan admin baru
            Route::get('/{admin}', [AdminController::class, 'show'])->name('admin.admins.show'); // Detail admin
            Route::get('/{admin}/edit', [AdminController::class, 'editAdmin'])->name('admin.admins.edit'); // Form edit admin
            Route::put('/{admin}', [AdminController::class, 'updateAdmin'])->name('admin.admins.update'); // Update admin (Ganti sebagian)
            Route::delete('/{admin}', [AdminController::class, 'deleteAdmin'])->name('admin.admins.destroy'); // Hapus admin

            Route::post('/{admin}/verify', [AdminController::class, 'verifyAdmin'])->name('admin.admins.verify');
            Route::post('/{admin}/activate', [AdminController::class, 'activateAdmin'])->name('admin.admins.activate');
            Route::post('/{admin}/deactivate', [AdminController::class, 'deactivateAdmin'])->name('admin.admins.deactivate');
        });
        
        Route::get('/admin', [AdminController::class, 'adminPage'])->name('admin.admin');
        Route::get('/history', [AdminController::class, 'historyPage'])->name('admin.history');
        
        // Session Management Routes
        Route::get('/admin-login-history/{adminId?}', [AdminController::class, 'adminLoginHistory'])->name('admin.login-history');
        Route::post('/clean-old-sessions', [AdminController::class, 'cleanOldSessions'])->name('admin.clean-sessions');
        
        // Additional Admin Management Routes (duplicates removed - using the main admin routes above)
        Route::post('/check-email', [AdminController::class, 'checkEmailAvailability'])->name('admin.check-email');
        
        // Customer Management Routes
            Route::prefix('customers')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers.index');
        Route::get('/search', [App\Http\Controllers\Admin\CustomerController::class, 'search'])->name('admin.customers.search');
        Route::get('/stats', [App\Http\Controllers\Admin\CustomerController::class, 'getStats'])->name('admin.customers.stats');
        Route::get('/export', [App\Http\Controllers\Admin\CustomerController::class, 'export'])->name('admin.customers.export');
        Route::post('/send-email', [App\Http\Controllers\Admin\CustomerController::class, 'sendEmailAjax'])->name('admin.customers.send-email-ajax');
        Route::get('/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('admin.customers.show');
        Route::put('/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('admin.customers.update');
        Route::delete('/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('admin.customers.destroy');
        Route::post('/{customer}/send-email', [App\Http\Controllers\Admin\CustomerController::class, 'sendEmail'])->name('admin.customers.send-email');
        });
        
        Route::get('/email-verification/{email}', [AdminController::class, 'emailVerification'])->name('admin.email-verification');
        Route::get('/email-confirmation', [AdminController::class, 'emailConfirmation'])->name('admin.email-confirmation');
        Route::post('/verify-email', [EmailVerificationController::class, 'verify'])->name('verify.email.submit');
    });
  });
  
  // Database health check route (add this at the end)
Route::get('/admin/health/database', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'connected',
            'message' => 'Database connection is healthy',
            'timestamp' => now()
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'disconnected',
            'message' => 'Database connection failed',
            'timestamp' => now()
        ], 503);
    }
})->name('admin.health.database');