<?php

use App\Http\Controllers\TechVerse\BlogPageController;
use App\Http\Controllers\TechVerse\CaseStudyController;
use App\Http\Controllers\TechVerse\HomePageController;
use Illuminate\Support\Facades\Route;

// HomePage route
Route::get('/homepage/services', [HomePageController::class, 'getServices']);
Route::get('/homepage/blogs', [HomePageController::class, 'getBlogs']);
Route::get('/homepage/case-studies', [HomePageController::class, 'getCaseStudies']);
Route::get('/detail-articles/{id}', [HomePageController::class, 'getDetailArticle']);
Route::get('/homepage/advertisement', [HomePageController::class, 'getAdvertisement']);

// BlogPage route
Route::get('/blogs', [BlogPageController::class, 'getAllBlogs']);

// Case studies route
Route::get('/case-studies', [CaseStudyController::class, 'getCaseStudies']);
