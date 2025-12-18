<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TechVerse\HomePageController;
use Illuminate\Support\Facades\Route;

// HomePage route
Route::get('/homepage/services', [HomePageController::class, 'getServices']);
Route::get('/homepage/blogs', [HomePageController::class, 'getBlogs']);
Route::get('/homepage/case-studies', [HomePageController::class, 'getCaseStudies']);
Route::get('/detail-articles/{id}', [HomePageController::class, 'getDetailArticle']);
