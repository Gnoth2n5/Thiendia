<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModificationRequestController;
use Illuminate\Support\Facades\Route;

// Trang chủ công khai
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tìm kiếm lăng mộ
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Chi tiết lăng mộ
Route::get('/grave/{id}', [HomeController::class, 'show'])->name('grave.show');

// Yêu cầu sửa đổi
Route::get('/grave/{grave}/modification-request', [ModificationRequestController::class, 'create'])->name('modification-request.create');
Route::post('/modification-request', [ModificationRequestController::class, 'store'])->name('modification-request.store');
Route::post('/modification-request/{id}/approve', [ModificationRequestController::class, 'approve'])->name('modification-request.approve');
Route::post('/modification-request/{id}/reject', [ModificationRequestController::class, 'reject'])->name('modification-request.reject');

// Bài viết
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/articles/category/{category}', [ArticleController::class, 'category'])->name('articles.category');

// Liên hệ
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
