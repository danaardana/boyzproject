<?php

use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/admin/landing', [LandingPageController::class, 'edit'])->name('admin.manage-landing');
Route::post('/admin/landing', [LandingPageController::class, 'update']);


