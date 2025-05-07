<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/landing/login', [LandingPageController::class, 'showLoginForm'])->name('login');
Route::post('/landing/login', [LandingPageController::class, 'login'])->name('login.submit');


//Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    Route::get('/admin/lockscreen', [AdminController::class, 'lockscreen'])->name('admin.lockscreen');
    Route::post('/admin/unlock', [AdminController::class, 'unlock'])->name('admin.unlock');
    
    Route::get('/', [AdminController::class, 'landingPage'])->name('landing-page');
    Route::get('/admin/landingpage-tables', [AdminController::class, 'landingPageTables'])->name('admin.landingPageTables');
    Route::get('/admin/subsection-tables', [AdminController::class, 'subsectionTables'])->name('admin.subsectionTables');
    Route::get('/admin/subsections/{id}', [AdminController::class, 'subsectionTables'])->name('admin.subsection_tables');

    Route::get('/admin/portofolio', function () {
        return app()->call('App\Http\Controllers\TableController@show', ['type' => 'portofolio']);
    })->name('admin.portofolio');

    Route::get('/admin/instagram', function () {
        return app()->call('App\Http\Controllers\TableController@show', ['type' => 'instagram']);
    })->name('admin.instagram');

    Route::get('/admin/tiktok', function () {
        return app()->call('App\Http\Controllers\TableController@show', ['type' => 'tiktok']);
    })->name('admin.tiktok');

    Route::get('/admin/testimonials', function () {
        return app()->call('App\Http\Controllers\TableController@show', ['type' => 'testimonials']);
    })->name('admin.testimonials');

    Route::get('/admin/promotion', function () {
        return app()->call('App\Http\Controllers\TableController@show', ['type' => 'promotion']);
    })->name('admin.promotion');

    Route::get('/admin/categories', function () {
        return app()->call('App\Http\Controllers\TableController@show', ['type' => 'categories']);
    })->name('admin.categories');
        
    Route::put('/admin/section-content/{id}', [AdminController::class, 'update'])->name('section_content.update');    
    Route::get('/admin/faq', [AdminController::class, 'faqPage'])->name('admin.faq');;    
    Route::get('/admin/chat', [AdminController::class, 'chatPage'])->name('admin.chat');;    
    Route::get('/admin/admin', [AdminController::class, 'adminPage'])->name('admin.admin');;
    Route::get('/admin/history', [AdminController::class, 'historyPage'])->name('admin.history');;
    Route::get('/admin/email-verification/{email}', [AdminController::class, 'emailVerification'])->name('admin.email-verification');;
    Route::get('/admin/email-confirmation', [AdminController::class, 'emailConfirmation'])->name('admin.email-confirmation');;

    Route::post('/admin/verify-email', [EmailVerificationController::class, 'verify'])->name('verify.email.submit');

//});