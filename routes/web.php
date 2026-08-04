<?php

use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Host\PropertyController as HostPropertyController;
use App\Models\Property;
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
    // Same throttle as login: a public signup endpoint is otherwise an
    // open invitation to script bulk account creation.
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:6,1');

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
        $properties = auth()->user()->properties();

        return view('host.dashboard', [
            'totalProperties' => (clone $properties)->count(),
            'activeListings'  => (clone $properties)->where('is_visible', true)->count(),
            'approvedCount'   => (clone $properties)->where('listing_status', Property::STATUS_APPROVED)->count(),
            'pendingCount'    => (clone $properties)->where('listing_status', Property::STATUS_PENDING)->count(),
            'totalLeads'      => \App\Models\LeadAnalytic::whereIn(
                'property_id', (clone $properties)->pluck('id')
            )->count(),
        ]);
    })->name('dashboard');

    Route::resource('properties', HostPropertyController::class)->except(['show']);
    Route::get('/properties/{property}', [HostPropertyController::class, 'show'])->name('properties.show');
});

/*
|--------------------------------------------------------------------------
| Admin area
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $byStatus = Property::selectRaw('listing_status, COUNT(*) as total')
            ->groupBy('listing_status')
            ->pluck('total', 'listing_status');

        return view('admin.dashboard', [
            'pendingCount'  => (int) $byStatus->get(Property::STATUS_PENDING, 0),
            'approvedCount' => (int) $byStatus->get(Property::STATUS_APPROVED, 0),
            'rejectedCount' => (int) $byStatus->get(Property::STATUS_REJECTED, 0),
        ]);
    })->name('dashboard');

    Route::get('/properties', [AdminPropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/{property}', [AdminPropertyController::class, 'show'])->name('properties.show');
    Route::post('/properties/{property}/approve', [AdminPropertyController::class, 'approve'])->name('properties.approve');
    Route::post('/properties/{property}/reject', [AdminPropertyController::class, 'reject'])->name('properties.reject');
});
