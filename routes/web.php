<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\barangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;


// Route default
Route::get('/testing12331912',  function(){
    return view('welcome');
});
Route::get('/autocomplete-barang', [BarangController::class, 'autocomplete'])
    ->name('autocomplete.barang');
Route::get('/autocomplete-pelanggan', [PelangganController::class, 'autocomplete'])
    ->name('autocomplete.pelanggan');
Route::get('/autocomplete-pemasok', [PemasokController::class, 'autocomplete'])
    ->name('autocomplete.pemasok');

Route::get('/', [PesananController::class, 'index'])->name('pesanan.index');
Route::post('/pesanan/store', [PesananController::class, 'store'])->name('pesanan.store');
Route::get('/pesanan', [PesananController::class, 'list'])->name('pesanan.list');
Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');

Route::middleware('guest')->group(function () {
    Route::get('/signin', [AuthController::class, 'showSignin'])->name('signin.show');
    Route::post('/signin', [AuthController::class, 'submitSignin'])->name('signin.submit');
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup.show');
    Route::post('/signup', [AuthController::class, 'submitSignup'])->name('signup.submit');
});

// protected route
Route::middleware('auth')->group(function () {
    Route::get('/signout', [AuthController::class, 'signOut'])->name('signout');
    
    // admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [DashboardController::class, 'showDashboard'])->name('admin.show');
        
        Route::get('/admin/barang', [barangController::class, 'tampilkanDataBarang'])->name('admin.barang');
        Route::post('/admin/barang/', [barangController::class, 'addDataBarang'])->name('barang.add');
        Route::put('/admin/barang/{id_barang}', [barangController::class, 'updateDataBarang'])->name('barang.update');
        Route::put('/admin/barang/stok/{id_barang}', [barangController::class, 'addStok'])->name('stok.add');

        Route::get('/admin/pesanan', [PesananController::class, 'listAdmin'])->name('admin.pesanan');
        
        Route::get('/admin/pembelian', [PembelianController::class, 'listAdmin'])->name('admin.pembelian');
        Route::post('/admin/pembelian/store', [PembelianController::class, 'addDataPembelian'])->name('pembelian.add');

        Route::get('/admin/pelanggan', [PelangganController::class, 'tampilkanDataPelanggan'])->name('admin.pelanggan');
        Route::post('/admin/pelanggan/', [PelangganController::class, 'addDataPelanggan'])->name('pelanggan.add');
        Route::put('/admin/pelanggan/{id_pelanggan}', [PelangganController::class, 'updateDataPelanggan'])->name('pelanggan.update');
        
        Route::get('/admin/pemasok', [PemasokController::class, 'tampilkanDataPemasok' ])->name('admin.pemasok');
        Route::post('/admin/pemasok/', [PemasokController::class, 'addDataPemasok'])->name('pemasok.add');
        Route::put('/admin/pemasok/{id_pemasok}', [PemasokController::class, 'updateDataPemasok'])->name('pemasok.update');
    });
    // user
    Route::middleware('role:user')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'showUser'])->name('user.show');
    });
});
