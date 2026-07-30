<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/apartment/v4', function () {
    return view('apartment.v4');
});

Route::get('/single/index5', function () {
    return view('single.index5');
});

/*
|--------------------------------------------------------------------------
| Auth (guests only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // throttle:6,1 = 6 attempts per minute per IP+route, to blunt password
    // brute-forcing. Remove only if it interferes with client testing.
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:6,1');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Host area
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'host'])->prefix('host')->name('host.')->group(function () {
    Route::get('/dashboard', function () {
        return view('host.dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin area
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});
