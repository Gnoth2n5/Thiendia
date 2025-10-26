<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Trang chủ công khai
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tìm kiếm lăng mộ
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Chi tiết lăng mộ
Route::get('/grave/{id}', [HomeController::class, 'show'])->name('grave.show');

// Bài viết
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/articles/category/{category}', [ArticleController::class, 'category'])->name('articles.category');
