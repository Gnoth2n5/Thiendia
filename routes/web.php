<?php

use App\Http\Controllers\AnniversaryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Login redirect for Filament
Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');

// Trang chủ công khai
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tìm kiếm lăng mộ
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Ngày giỗ hôm nay
Route::get('/today-death-anniversary', [AnniversaryController::class, 'index'])->name('anniversary.today');

// Chi tiết lăng mộ
Route::get('/grave/{id}', [HomeController::class, 'show'])->name('grave.show');

// Sơ đồ nghĩa trang
Route::get('/cemetery/{id}/map', [HomeController::class, 'cemeteryMap'])->name('cemetery.map');

// Bài viết
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/articles/category/{category}', [ArticleController::class, 'category'])->name('articles.category');

// Các trang chính sách và hỗ trợ
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/terms-of-service', function () {
    return view('terms-of-service');
})->name('terms-of-service');

Route::get('/guide', function () {
    return view('guide');
})->name('guide');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
