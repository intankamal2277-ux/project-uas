<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteCategoryController;
use App\Http\Controllers\SavedNewsController;
use Illuminate\Support\Facades\Route;

// Halaman utama (sementara welcome, nanti terintegrasi dengan Mhs 2)
Route::get('/', function () {
    return view('welcome');
})->name('home');

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

    // Pengaturan Kategori Favorit
    Route::post('/favorites', [FavoriteCategoryController::class, 'update'])->name('favorites.update');

    // Fitur Simpan Berita (Bookmarks)
    Route::get('/saved-news', [SavedNewsController::class, 'index'])->name('saved-news.index');
    Route::post('/saved-news', [SavedNewsController::class, 'store'])->name('saved-news.store');
    Route::delete('/saved-news/{id}', [SavedNewsController::class, 'destroy'])->name('saved-news.destroy');
});