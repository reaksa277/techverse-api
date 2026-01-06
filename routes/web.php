<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\UserController;
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

    Route::get('/admin/users', [UserController::class, 'view'])->name('admin.users');
    Route::get('/admin/slides', [SlideController::class, 'view'])->name('admin.slides');
    Route::get('/admin/categoryarticles', [CategoryArticleController::class, 'view'])->name('admin.categoryarticles');
    Route::get('/admin/articles', [ArticleController::class, 'view'])->name('admin.article');
});
