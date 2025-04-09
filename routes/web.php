<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Rute login
Route::get('/login', [LandingPageController::class, 'showLoginForm'])->name('landing.login');

// Rute untuk memproses login
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

// Rute admin dashboard
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');});

    Route::get('/table/{tableName}', [AdminController::class, 'showTable'])->name('table.show');

    Route::get('/admin/tables', [TableController::class, 'show'])->name('admin.tables');