<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteCategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SavedNewsController;
use Illuminate\Support\Facades\Route;

// Halaman Utama & Detail Berita (Akses Publik)
Route::get('/', [NewsController::class, 'index'])->name('home');
Route::get('/news/detail', [NewsController::class, 'detail'])->name('news.detail');

// Rute untuk Tamu (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rute untuk Pengguna Terautentikasi (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Pengaturan Kategori Favorit (Mhs 1)
    Route::post('/favorites', [FavoriteCategoryController::class, 'update'])->name('favorites.update');

    // Fitur Simpan Berita / Bookmarks (Mhs 1)
    Route::get('/saved-news', [SavedNewsController::class, 'index'])->name('saved-news.index');
    Route::post('/saved-news', [SavedNewsController::class, 'store'])->name('saved-news.store');
    Route::delete('/saved-news/{id}', [SavedNewsController::class, 'destroy'])->name('saved-news.destroy');

    // Fitur Tulis & Hapus Komentar (Mhs 3)
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Rute Khusus Administrator (Sudah Login & Role = Admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});