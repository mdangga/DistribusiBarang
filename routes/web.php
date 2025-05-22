<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\barangController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TransaksiController;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Route default
Route::get('/testing12331912',  function(){
    return view('welcome');
});
Route::get('/autocomplete-barang', [BarangController::class, 'autocomplete'])
    ->name('autocomplete.barang');
Route::get('/autocomplete-pelanggan', [PelangganController::class, 'autocomplete'])
    ->name('autocomplete.pelanggan');

Route::get('/', [PesananController::class, 'index'])->name('pesanan.index');
Route::post('/pesanan/store', [PesananController::class, 'store'])->name('pesanan.store');
Route::get('/pesanan', [PesananController::class, 'list'])->name('pesanan.list');
Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
Route::get('/defaultAdmin', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return match ($user->role) {
            'admin' => redirect()->route('admin.show'),
            default => redirect()->route('user.show')
        };
    }
    return redirect()->route('signin.show');
})->name('default.show');

Route::middleware('guest')->group(function () {
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup.show');
    Route::post('/signup', [AuthController::class, 'submitSignup'])->name('signup.submit');
    Route::get('/login123123', [AuthController::class, 'showSignin'])->name('signin.show');
    Route::post('/login123123', [AuthController::class, 'submitSignin'])->name('signin.submit');
});

// protected route
Route::middleware('auth')->group(function () {
    Route::get('/signout', [AuthController::class, 'signOut'])->name('signout');

    // admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AuthController::class, 'showAdmin'])->name('admin.show');
        Route::get('/admin/barang', [barangController::class, 'tampilkanDataBarang'])->name('admin.barang');
        Route::post('/admin/barang/', [barangController::class, 'addDataBarang'])->name('barang.add');
        Route::put('/admin/barang/{id_barang}', [barangController::class, 'updateDataBarang'])->name('barang.update');
        Route::get('/admin/transaksi', [TransaksiController::class, 'tampilkanDataTransaksi'])->name('admin.transaksi');
        Route::get('/admin/pelanggan', [PelangganController::class, 'tampilkanDataPelanggan'])->name('admin.pelanggan');
    });
    // user
    Route::middleware('role:user')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'showUser'])->name('user.show');
    });
});
