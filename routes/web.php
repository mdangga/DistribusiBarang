<?php

use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Route;

// route Sign Up
route::get('/signup', [authController::class, 'showSignup'])-> name('signup.show');
route::post('/signup/submit', [authController::class, 'submitSignup'])-> name('signup.submit');

// route Sign In
route::get('/signin', [authController::class, 'showSignin'])-> name('signin.show');
route::post('/signin/submit', [authController::class, 'submitSignin'])-> name('signin.submit');
route::get('/welcome', [authController::class, 'showWelcome'])-> name('welcome.show');