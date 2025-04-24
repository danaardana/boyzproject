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

    Route::get('/', [AdminController::class, 'landingPage'])->name('landing-page');
    
    Route::get('/admin/landingpage-tables', [AdminController::class, 'landingPageTables'])->name('admin.landingPageTables');

    Route::get('/admin/subsection-tables', [AdminController::class, 'subsectionTables'])->name('admin.subsectionTables');

    Route::get('/admin/subsections/{id}', [AdminController::class, 'subsectionTables'])->name('admin.subsection_tables');

    Route::get('/table/{tableName}', [AdminController::class, 'showTable'])->name('table.show');

    Route::get('/admin/tables', [TableController::class, 'show'])->name('admin.tables');
    
    Route::put('/admin/section-content/{id}', [AdminController::class, 'update'])->name('section_content.update');
    
    Route::get('/admin/faq', [AdminController::class, 'faqPage'])->name('admin.faq');;
    
    Route::get('/admin/chat', [AdminController::class, 'chatPage'])->name('admin.chat');;
    
    Route::get('/admin/admin', [AdminController::class, 'adminPage'])->name('admin.admin');;
//});