<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Admin Management for Sections
Route::get('/admin/sections', [AdminController::class, 'index'])->name('admin.sections');
Route::post('/admin/sections/update', [AdminController::class, 'update'])->name('admin.sections.update');

Route::fallback(function () {
    return response()->view('landing.errors.404', [], 404);
});

// Login
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login']);
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
