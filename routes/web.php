<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin']);
    Route::post('login', [AuthController::class, 'login'])->name('admin.authentication');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {

    # DashboardBackend
    Route::get('dashboard', [DashboardController::class, 'view'])->name('admin.dashboard');
});
