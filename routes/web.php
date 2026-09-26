<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuLikeController;
use App\Http\Controllers\Seller\MenuController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/jadwal-kuliner', [HomeController::class, 'jadwalKuliner'])->name('jadwal-kuliner');

Route::get('/info-rt', function () {
    return view('info-rt', ['active' => 'info-rt']);
})->name('info-rt');

Route::post('/menu/{menu}/suka', [MenuLikeController::class, 'toggle'])
    ->middleware('throttle:60,1')
    ->name('menus.like');

Route::get('/layanan', function () {
    return view('layanan.index', ['active' => 'layanan']);
})->name('layanan');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::redirect('/register/layanan', '/register')->name('register.layanan');

Route::middleware('auth')->group(function () {
    Route::get('/seller/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');
    Route::post('/seller/lapak/toggle', [SellerController::class, 'toggleLapak'])->name('seller.lapak.toggle');

    Route::get('/seller/menu/create', [MenuController::class, 'create'])->name('seller.menu.create');
    Route::post('/seller/menu', [MenuController::class, 'store'])->name('seller.menu.store');
    Route::get('/seller/menu/{menu}/edit', [MenuController::class, 'edit'])->name('seller.menu.edit');
    Route::put('/seller/menu/{menu}', [MenuController::class, 'update'])->name('seller.menu.update');
    Route::delete('/seller/menu/{menu}', [MenuController::class, 'destroy'])->name('seller.menu.destroy');
    Route::post('/seller/menu/{menu}/toggle', [MenuController::class, 'toggle'])->name('seller.menu.toggle');
    Route::post('/seller/menu/{menu}/stock', [MenuController::class, 'adjustStock'])->name('seller.menu.stock');

    Route::get('/seller/pesanan', [OrderController::class, 'index'])->name('seller.pesanan.index');
    Route::post('/seller/pesanan', [OrderController::class, 'store'])->name('seller.pesanan.store');
    Route::patch('/seller/pesanan/{order}/status', [OrderController::class, 'updateStatus'])->name('seller.pesanan.status');
    Route::delete('/seller/pesanan/{order}', [OrderController::class, 'destroy'])->name('seller.pesanan.destroy');

    Route::get('/seller/pengaturan', [SettingsController::class, 'edit'])->name('seller.pengaturan.edit');
    Route::put('/seller/pengaturan', [SettingsController::class, 'update'])->name('seller.pengaturan.update');

    Route::view('/superadmin/dashboard', 'superadmin.dashboard')->name('superadmin.dashboard');
    Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/layanan/dashboard', 'layanan.dashboard')->name('layanan.dashboard');
});