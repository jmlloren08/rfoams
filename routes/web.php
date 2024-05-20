<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\agenciesController;
use App\Http\Controllers\ccController;
use App\Http\Controllers\commendationController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ebossController;
use App\Http\Controllers\lguController;
use App\Http\Controllers\orientationController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
});

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // display
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/eboss', [ebossController::class,'index'])->name('admin.eboss');
    Route::get('/admin/citizens-charter', [ccController::class,'index'])->name('admin.citizens-charter');
    Route::get('/admin/orientation', [orientationController::class,'index'])->name('admin.orientation');
    Route::get('/admin/commendation', [commendationController::class,'index'])->name('admin.commendation');
    Route::get('/admin/agencies', [agenciesController::class,'index'])->name('admin.agencies');
    Route::get('/admin/lgus', [lguController::class,'index'])->name('admin.lgus');
    Route::get('/admin/users', [userController::class,'index'])->name('admin.users');
    Route::get('/admin/contact', [contactController::class,'index'])->name('admin.contact');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
