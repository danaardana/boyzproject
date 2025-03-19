<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Admin Management for Sections
Route::get('/admin/sections', [AdminController::class, 'index'])->name('admin.sections');
Route::post('/admin/sections/update', [AdminController::class, 'update'])->name('admin.sections.update');

Route::fallback(function () {
    return response()->view('landing.errors.404', [], 404);
});