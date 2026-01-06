<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryArticleController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    require __DIR__ . '/api/v1.php';
});
Route::middleware('auth:sanctum')->group(function () {
    
    // User route
    Route::get('/users', [UserController::class, 'index'])->name('users.get-data');
    Route::post('/users/add', [UserController::class, 'store'])->name('users.add');
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.delete');

    // Slide route
    Route::post('/slides', [SlideController::class, 'store'])->name('slides.add');
    Route::get('/slides', [SlideController::class, 'index'])->name('slides.get-data');
    Route::get('/slides/{id}', [SlideController::class, 'show']);
    Route::put('/slides/{id}', [SlideController::class, 'update'])->name('slides.update');
    Route::delete('/slides/{id}', [SlideController::class, 'destroy'])->name('slides.delete');

    // CategoryArticle route
    Route::post('/categoryarticles/add', [CategoryArticleController::class, 'store'])->name('categoryarticles.add');
    Route::get('/categoryarticles', [CategoryArticleController::class, 'index'])->name('categoryarticles.get-data');
    Route::get('/categoryarticles/{id}', [CategoryArticleController::class, 'show']);
    Route::put('/categoryarticles/{id}', [CategoryArticleController::class, 'update'])->name('categoryarticles.update');
    Route::delete('/categoryarticles/{id}', [CategoryArticleController::class, 'destroy'])->name('categoryarticles.delete');

    // Article route
    Route::post('/articles/add', [ArticleController::class, 'store'])->name('articles.add');
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.get-data');
    Route::get('/articles/{id}', [ArticleController::class, 'show']);
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.delete');
});
