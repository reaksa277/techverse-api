<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryArticleController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    require __DIR__.'/api/v1.php';
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    // User route
    Route::post('/users/add', [UserController::class, 'store'])->name('users.add');
    Route::get('/users', [UserController::class, 'index'])->name('users.get-data');
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::get('/admin/users', [UserController::class, 'view'])->name('admin.users');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/admin/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');

    // Slide route
    Route::post('/slides', [SlideController::class, 'store'])->name('slides.add');
    Route::get('/slides', [SlideController::class, 'index'])->name('slides.get-data');
    Route::get('/slides/{id}', [SlideController::class, 'show']);
    Route::put('/slides/{id}', [SlideController::class, 'update'])->name('slide.update');
    Route::delete('/slides/{id}', [SlideController::class, 'destroy']);
    Route::get('/admin/slides', [SlideController::class, 'view'])->name('admin.slides');
    Route::get('/admin/slides/create', [SlideController::class, 'create'])->name('slides.create');
    Route::get('/admin/slides/edit/{id}', [SlideController::class, 'edit'])->name('slide.edit');

    // CategoryArticle route
    Route::post('/categoryarticles/add', [CategoryArticleController::class, 'store'])->name('categoryarticles.add');
    Route::get('/categoryarticles', [CategoryArticleController::class, 'index'])->name('categoryarticles.get-data');
    Route::get('/categoryarticles/{id}', [CategoryArticleController::class, 'show']);
    Route::put('/categoryarticles/{id}', [CategoryArticleController::class, 'update'])->name('categoryarticles.update');
    Route::delete('/categoryarticles/{id}', [CategoryArticleController::class, 'destroy']);
    Route::get('/admin/categoryarticles', [CategoryArticleController::class, 'view'])->name('admin.categoryarticles');
    Route::get('/admin/categoryarticles/create', [CategoryArticleController::class, 'create'])->name('categoryarticles.create');
    Route::get('/admin/categoryarticles/edit/{id}', [CategoryArticleController::class, 'edit'])->name('categoryarticles.edit');

    // Article route
    Route::post('/articles/add', [ArticleController::class, 'store'])->name('article.add');
    Route::get('/articles', [ArticleController::class, 'index'])->name('article.get-data');
    Route::get('/articles/{id}', [ArticleController::class, 'show']);
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('article.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);
    Route::get('/admin/articles', [ArticleController::class, 'view'])->name('admin.article');
    Route::get('/admin/articles/create', [ArticleController::class, 'create'])->name('article.create');
    Route::get('/admin/articles/edit/{id}', [ArticleController::class, 'edit'])->name('article.edit');
});
