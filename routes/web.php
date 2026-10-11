<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InfoRtController;
use App\Http\Controllers\Seller\MenuController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\SettingsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceOptionController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\ServiceSettingsController;
use App\Http\Controllers\MenuLikeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/jadwal-kuliner', [HomeController::class, 'jadwalKuliner'])->name('jadwal-kuliner');
Route::get('/info-rt', function () { return view('info-rt'); })->name('info-rt');
Route::post('/menu/{menu}/suka', [MenuLikeController::class, 'toggle'])->middleware('throttle:60,1')->name('menus.like');
Route::get('/layanan', [ServiceController::class, 'index'])->name('layanan');

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

    Route::get('/layanan/dashboard', [ServiceController::class, 'dashboard'])->name('layanan.dashboard');
    Route::get('/layanan/opsi', [ServiceOptionController::class, 'index'])->name('layanan.opsi.index');
    Route::post('/layanan/opsi', [ServiceOptionController::class, 'store'])->name('layanan.opsi.store');
    Route::delete('/layanan/opsi/{option}', [ServiceOptionController::class, 'destroy'])->name('layanan.opsi.destroy');
    Route::get('/layanan/pesanan', [ServiceOrderController::class, 'index'])->name('layanan.pesanan.index');
    Route::post('/layanan/pesanan', [ServiceOrderController::class, 'store'])->name('layanan.pesanan.store');
    Route::patch('/layanan/pesanan/{order}/status', [ServiceOrderController::class, 'updateStatus'])->name('layanan.pesanan.status');
    Route::delete('/layanan/pesanan/{order}', [ServiceOrderController::class, 'destroy'])->name('layanan.pesanan.destroy');
    Route::get('/layanan/pengaturan', [ServiceSettingsController::class, 'edit'])->name('layanan.pengaturan.edit');
    Route::put('/layanan/pengaturan', [ServiceSettingsController::class, 'update'])->name('layanan.pengaturan.update');
    Route::get('/layanan/create', [ServiceController::class, 'create'])->name('layanan.create');
    Route::post('/layanan', [ServiceController::class, 'store'])->name('layanan.store');
    Route::get('/layanan/{service}/edit', [ServiceController::class, 'edit'])->name('layanan.edit');
    Route::put('/layanan/{service}', [ServiceController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{service}', [ServiceController::class, 'destroy'])->name('layanan.destroy');
    Route::post('/layanan/{service}/toggle', [ServiceController::class, 'toggleStatus'])->name('layanan.toggle');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('pengguna', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'update', 'destroy']);
        Route::patch('pengguna/{pengguna}/toggle-aktif', [\App\Http\Controllers\Admin\UserController::class, 'toggleAktif'])->name('pengguna.toggle-aktif');
        Route::get('kuliner', [\App\Http\Controllers\Admin\KulinerController::class, 'index'])->name('kuliner.index');
        Route::patch('kuliner/{menu}/toggle', [\App\Http\Controllers\Admin\KulinerController::class, 'toggle'])->name('kuliner.toggle');
        Route::delete('kuliner/{menu}', [\App\Http\Controllers\Admin\KulinerController::class, 'destroy'])->name('kuliner.destroy');
        Route::post('kuliner/lapak/{user}/toggle', [\App\Http\Controllers\Admin\KulinerController::class, 'toggleLapak'])->name('kuliner.lapak.toggle');
        Route::get('layanan', [\App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('layanan.index');
        Route::patch('layanan/{service}/toggle', [\App\Http\Controllers\Admin\ServiceController::class, 'toggle'])->name('layanan.toggle');
        Route::delete('layanan/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'destroy'])->name('layanan.destroy');
        Route::get('info-rt', [InfoRtController::class, 'index'])->name('info-rt.index');
        Route::post('info-rt/settings', [InfoRtController::class, 'updateSettings'])->name('info-rt.settings.update');
        Route::post('info-rt/announcements', [InfoRtController::class, 'storeAnnouncement'])->name('info-rt.announcements.store');
        Route::put('info-rt/announcements/{announcement}', [InfoRtController::class, 'updateAnnouncement'])->name('info-rt.announcements.update');
        Route::delete('info-rt/announcements/{announcement}', [InfoRtController::class, 'destroyAnnouncement'])->name('info-rt.announcements.destroy');
        Route::post('info-rt/contacts', [InfoRtController::class, 'storeContact'])->name('info-rt.contacts.store');
        Route::put('info-rt/contacts/{contact}', [InfoRtController::class, 'updateContact'])->name('info-rt.contacts.update');
        Route::delete('info-rt/contacts/{contact}', [InfoRtController::class, 'destroyContact'])->name('info-rt.contacts.destroy');
        Route::post('info-rt/gallery', [InfoRtController::class, 'storeGallery'])->name('info-rt.gallery.store');
        Route::delete('info-rt/gallery/{gallery}', [InfoRtController::class, 'destroyGallery'])->name('info-rt.gallery.destroy');
    });

    Route::view('/superadmin/dashboard', 'superadmin.dashboard')->name('superadmin.dashboard');
});
