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

    Route::post('/logout', action: [AuthController::class, 'logout'])->name('admin.logout');

    # DashboardBackend
    Route::get('dashboard', [DashboardController::class, 'view'])->name('admin.dashboard');

    Route::get('/users', [UserController::class, 'view'])->name('admin.users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');

    Route::get('/slides', [SlideController::class, 'view'])->name('admin.slides');
    Route::get('/slides/create', [SlideController::class, 'create'])->name('slides.create');
    Route::get('/slides/edit/{id}', [SlideController::class, 'edit'])->name('slides.edit');

    Route::get('/categoryarticles', [CategoryArticleController::class, 'view'])->name('admin.categoryarticles');
    Route::get('/categoryarticles/create', [CategoryArticleController::class, 'create'])->name('categoryarticles.create');
    Route::get('/categoryarticles/edit/{id}', [CategoryArticleController::class, 'edit'])->name('categoryarticles.edit');

    Route::get('/articles', [ArticleController::class, 'view'])->name('admin.articles');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('article.create');
    Route::get('/articles/edit/{id}', [ArticleController::class, 'edit'])->name('article.edit');
});
