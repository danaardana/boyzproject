<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');

// Admin Management for Sections
Route::get('/admin/sections', [AdminController::class, 'index'])->name('admin.sections');
Route::post('/admin/sections/update', [AdminController::class, 'update'])->name('admin.sections.update');
