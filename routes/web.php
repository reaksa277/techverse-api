<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::get('/admin/register', [AuthController::class, 'Register'])->name('admin.register');
    Route::post('/register', [AuthController::class, 'registration'])->name('admin.registration');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.authentication');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {

    # DashboardBackend
    Route::get('dashboard', [DashboardController::class, 'view'])->name('admin.dashboard');
});
