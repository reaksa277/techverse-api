<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryArticleController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    require __DIR__.'/api/v1.php';
});


// Slide route
Route::post('/slides', [SlideController::class, 'store']);
Route::get('/slides', [SlideController::class, 'index'])->name('slides.get-data');
Route::get('/slides/{id}', [SlideController::class, 'show']);
Route::put('/slides/{id}', [SlideController::class, 'update']);
Route::delete('/slides/{id}', [SlideController::class, 'destroy']);

// CategoryArticle route
Route::post('/categoryarticles', [CategoryArticleController::class, 'store']);
Route::get('/categoryarticles', [CategoryArticleController::class, 'index']);
Route::get('/categoryarticles/{id}', [CategoryArticleController::class, 'show']);
Route::put('/categoryarticles/{id}', [CategoryArticleController::class, 'update']);
Route::delete('/categoryarticles/{id}', [CategoryArticleController::class, 'destroy']);

// Article route
Route::post('/articles', [ArticleController::class, 'store']);
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{id}', [ArticleController::class, 'show']);
Route::put('/articles/{id}', [ArticleController::class, 'update']);
Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);

# DashboardBackend
Route::get('/admin/dashboard', [DashboardController::class, 'view'])->name('admin.dashboard');
Route::get('/admin/slides', [SlideController::class, 'view'])->name('admin.slides');
