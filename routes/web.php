<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengeluaranBarangController;


Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::post('/login', [LoginController::class, 'handleLogin'])->name('login')->middleware('guest');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('get-data')->as('get-data.')->group(function () {
        Route::get('/products', [ProductController::class, 'getData'])->name('products');
        Route::get('cek-stok', [ProductController::class, 'cekStok'])->name('cek-stok');
        Route::get('cek-harga', [ProductController::class, 'cekHargaJual'])->name('cek-harga');
    });

    Route::prefix('users')->as('users.')->controller(UserController::class)->group(function () {
       Route::get('/','index')->name('index');
       Route::post('/store', 'store')->name('store');
       Route::delete('/destroy/{id}', 'destroy')->name('destroy');
       Route::post('ganti-password', 'gantiPassword')->name('ganti-password');
       Route::post('reset-password', 'resetPassword')->name('reset-password');
    });
    
    // master-data.kategori.index
    Route::prefix('master-data')->as('master-data.')->group(function () {
        Route::prefix('kategori')->as('kategori.')->controller(KategoriController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });
        Route::prefix('product')->as('product.')->controller(ProductController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });
    });
    Route::prefix('penerimaan-barang')->as('penerimaan-barang.')->controller(PenerimaanBarangController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });
      Route::prefix('pengeluaran-barang')->as('pengeluaran-barang.')->controller(PengeluaranBarangController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });
    
    Route::prefix('laporan')->as('laporan.')->group(function () {
        Route::prefix('penerimaan-barang')->as('penerimaan-barang.')->controller(PenerimaanBarangController::class)->group(function () {
        Route::get('/laporan', 'laporan')->name('laporan');
        Route::get('/laporan/detail/{no_penerimaan}', 'detailLaporan')->name('detail-laporan');
       });
    });

     Route::prefix('laporan')->as('laporan.')->group(function () {
        Route::prefix('pengeluaran-barang')->as('pengeluaran-barang.')->controller(PengeluaranBarangController::class)->group(function () {
        Route::get('/laporan', 'laporan')->name('laporan');
        Route::get('/laporan/detail/{no_pengeluaran}', 'detailLaporan')->name('detail-laporan');
       });
    });

});