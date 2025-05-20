<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\barangController;
use App\Http\Controllers\PesananController;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Route default
Route::get('/test',  function(){
    return view('welcome');
});
Route::get('/autocomplete-barang', [BarangController::class, 'autocomplete'])
    ->name('autocomplete.barang');

Route::get('/pesanan/form', [PesananController::class, 'index'])->name('pesanan.index');
Route::post('/pesanan/store', [PesananController::class, 'store'])->name('pesanan.store');
Route::get('/pesanan', [PesananController::class, 'list'])->name('pesanan.list');
Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
Route::get('/', function () {
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
    Route::get('/signin', [AuthController::class, 'showSignin'])->name('signin.show');
    Route::post('/signin', [AuthController::class, 'submitSignin'])->name('signin.submit');
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
    });
    // user
    Route::middleware('role:user')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'showUser'])->name('user.show');
    });
});
