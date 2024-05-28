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
use App\Http\Controllers\rfoController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
});

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // display
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/eboss', [ebossController::class, 'index'])->name('admin.eboss');
    Route::get('/admin/citizens-charter', [ccController::class, 'index'])->name('admin.citizens-charter');
    Route::get('/admin/orientation', [orientationController::class, 'index'])->name('admin.orientation');
    Route::get('/admin/commendation', [commendationController::class, 'index'])->name('admin.commendation');
    Route::get('/admin/agencies', [agenciesController::class, 'index'])->name('admin.agencies');
    Route::get('/admin/lgus', [lguController::class, 'index'])->name('admin.lgus');
    Route::get('/admin/rfos', [rfoController::class, 'index'])->name('admin.rfos');
    Route::get('/admin/users', [userController::class, 'index'])->name('admin.users');
    Route::get('/admin/contact', [contactController::class, 'index'])->name('admin.contact');
    // fetch data from database
    Route::post('/admin/lgus/getDataFromRefRegion', [lguController::class, 'getDataFromRefRegion'])->name('admin.lgus.getDataFromRefRegion');
    Route::post('/admin/lgus/getDataFromRefProvince', [lguController::class, 'getDataFromRefProvince'])->name('admin.lgus.getDataFromRefProvince');
    Route::post('/admin/lgus/getDataFromRefCityMun', [lguController::class, 'getDataFromRefCityMun'])->name('admin.lgus.getDataFromRefCityMun');
    Route::post('/admin/lgus/getDataFromRefBarangay', [lguController::class, 'getDataFromRefBarangay'])->name('admin.lgus.getDataFromRefBarangay');
    Route::post('/admin/agencies/getDataFromDepartmentAgency', [agenciesController::class, 'getDataFromDepartmentAgency'])->name('admin.agencies.getDataFromDepartmentAgency');
    Route::post('/admin/rfos/getDataFromRFOs', [rfoController::class, 'getDataFromRFOs'])->name('admin.rfos.getDataFromRFOs');
    Route::post('/admin/users/getDataFromUsers', [userController::class, 'getDataFromUsers'])->name('admin.users.getDataFromUsers');
    Route::post('/admin/eboss/getDataFromeBOSS', [ebossController::class, 'getDataFromeBOSS'])->name('admin.eboss.getDataFromeBOSS');
    // store data
    Route::post('/admin/rfos', [rfoController::class, 'store'])->name('admin.rfos.store');
    Route::post('/admin/eboss', [ebossController::class, 'store'])->name('admin.eboss.store');
    // update data
    Route::put('/admin/rfos/{id}', [rfoController::class, 'update']);
    Route::put('/admin/users/{id}', [userController::class, 'update']);
    // remove user assigned role
    Route::put('/admin/users/{id}', [userController::class, 'removeAssignedRole']);
    // get data
    Route::get('/admin/rfos/{id}', [rfoController::class, 'edit']);
    Route::get('/admin/users/{id}', [userController::class, 'edit']);
    Route::get('/get-provinces-by-region', [ebossController::class, 'getProvincesByRegion']);
    Route::get('/get-city-municipality-by-province', [ebossController::class, 'getCityMuncipalityByProvinceURL']);
    // delete data
    Route::delete('/admin/rfos/{id}', [rfoController::class, 'delete']);
    Route::delete('/admin/users/{id}', [userController::class, 'delete']);
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
