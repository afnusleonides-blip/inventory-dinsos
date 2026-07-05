<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Harus Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    | Dashboard
    */
    Route::get('/dashboard', [BarangController::class, 'dashboard'])->name('dashboard');

    /*
    | Tentang Sistem (Semua User)
    */
    Route::view('/about', 'about')->name('about');

    /*
    | Barang (Read - Semua User)
    */
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/export', [BarangController::class, 'exportBarang'])->name('barang.export');

    /*
    | Admin Only - CRUD Barang
    */
    Route::middleware('role:admin')->group(function () {
        Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
        Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    });

    /*
    | Barang Masuk (Semua User)
    */
    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
    Route::get('/barang-masuk/export', [BarangMasukController::class, 'exportExcel'])->name('barang-masuk.export');
    Route::get('/barang-masuk/create', [BarangMasukController::class, 'create'])->name('barang-masuk.create');
    Route::post('/barang-masuk/store', [BarangMasukController::class, 'store'])->name('barang-masuk.store');

    /*
    | Barang Keluar (Semua User)
    */
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
    Route::get('/barang-keluar/export', [BarangKeluarController::class, 'exportExcel'])->name('barang-keluar.export');
    Route::get('/barang-keluar/create', [BarangKeluarController::class, 'create'])->name('barang-keluar.create');
    Route::post('/barang-keluar/store', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');

    /*
    | Laporan (Semua User)
    */
    Route::get('/laporan/barang-masuk', [LaporanController::class, 'barangMasuk'])->name('laporan.barang-masuk');
    Route::get('/laporan/barang-keluar', [LaporanController::class, 'barangKeluar'])->name('laporan.barang-keluar');
    Route::get('/laporan/barang-masuk/pdf', [LaporanController::class, 'cetakBarangMasuk'])->name('laporan.barang-masuk.pdf');
    Route::get('/laporan/barang-keluar/pdf', [LaporanController::class, 'cetakBarangKeluar'])->name('laporan.barang-keluar.pdf');

    /*
    | Admin Only - User Management
    */
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    /*
    | Profile (Semua User)
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
