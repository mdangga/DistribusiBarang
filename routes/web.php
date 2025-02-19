<?php

use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Route default
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return match($user->role) {
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
    Route::middleware('role:admin')->group(function ()  {
        Route::get('/admin', [AuthController::class, 'showAdmin'])->name('admin.show');
    });
    // user
    Route::middleware('role:user')->group(function ()  {
        Route::get('/dashboard', [AuthController::class, 'showUser'])->name('user.show');
    });
});
