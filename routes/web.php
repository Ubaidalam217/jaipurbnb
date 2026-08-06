<?php

use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Host\AvailabilityController;
use App\Http\Controllers\Host\PaymentController;
use App\Http\Controllers\Host\PropertyController as HostPropertyController;
use App\Http\Controllers\PropertyController as PublicPropertyController;
use App\Models\LeadAnalytic;
use App\Models\Property;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // The homepage "featured stay" card used to link at /single/index5 - a
    // legacy template URL that redirects to /browse - so it never opened a
    // property detail page. Feed it a real listing instead. The same query
    // supplies the listing count, replacing a hardcoded "500+" claim.
    $visible = Property::query()
        ->where('listing_status', Property::STATUS_APPROVED)
        ->where('is_visible', true);

    return view('index', [
        'featured'     => (clone $visible)->with('coverImage')->latest()->first(),
        'listingCount' => (clone $visible)->count(),
    ]);
});

// Razorpay server-to-server callback. Deliberately public and outside the
// auth middleware - Razorpay has no session. It authenticates by HMAC
// signature instead, and is exempt from CSRF in bootstrap/app.php.
Route::post('/webhooks/razorpay', [PaymentController::class, 'webhook'])
    ->name('webhooks.razorpay');

Route::get('/contact', fn () => view('pages.contact'))->name('contact');

Route::get('/browse', [PublicPropertyController::class, 'index'])->name('properties.browse');
Route::get('/property/{id}', [PublicPropertyController::class, 'show'])
    ->whereNumber('id')
    ->name('properties.show');

// Legacy template URLs. Milestone 1 shipped these as static demo pages and
// they are still linked from the homepage; keep them resolving so no old
// link 404s. Remove once every view has been repointed.
Route::get('/apartment/v4', fn () => redirect()->route('properties.browse'));
Route::get('/single/index5', fn () => redirect()->route('properties.browse'));

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

    // Password reset. Route names are Laravel's conventional ones because the
    // framework's ResetPassword notification builds its link from
    // route('password.reset') - renaming them silently breaks the email.
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
        ->middleware('throttle:6,1')
        ->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->middleware('throttle:6,1')
        ->name('password.update');
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
        $propertyIds = (clone $properties)->pluck('id');
        $since30Days = now()->subDays(30);

        // One grouped query for the three 30-day counters, rather than
        // three separate COUNT queries.
        $leads30 = LeadAnalytic::whereIn('property_id', $propertyIds)
            ->where('clicked_at', '>=', $since30Days)
            ->selectRaw('lead_type, COUNT(*) as total')
            ->groupBy('lead_type')
            ->pluck('total', 'lead_type');

        $recentProperties = (clone $properties)
            ->withCount([
                'leads as profile_views_count' => fn ($q) => $q->where('lead_type', LeadAnalytic::TYPE_PROFILE_VIEW),
                'leads as whatsapp_clicks_count' => fn ($q) => $q->where('lead_type', LeadAnalytic::TYPE_WHATSAPP),
                'leads as call_clicks_count' => fn ($q) => $q->where('lead_type', LeadAnalytic::TYPE_CALL),
            ])
            ->latest()
            ->limit(5)
            ->get();

        return view('host.dashboard', [
            'totalProperties'   => (clone $properties)->count(),
            'activeListings'    => (clone $properties)->where('is_visible', true)->count(),
            'approvedCount'     => (clone $properties)->where('listing_status', Property::STATUS_APPROVED)->count(),
            'pendingCount'      => (clone $properties)->where('listing_status', Property::STATUS_PENDING)->count(),
            'totalLeads'        => LeadAnalytic::whereIn('property_id', $propertyIds)->count(),
            'profileViews30'    => (int) $leads30->get(LeadAnalytic::TYPE_PROFILE_VIEW, 0),
            'whatsappClicks30'  => (int) $leads30->get(LeadAnalytic::TYPE_WHATSAPP, 0),
            'callClicks30'      => (int) $leads30->get(LeadAnalytic::TYPE_CALL, 0),
            'recentProperties'  => $recentProperties,
        ]);
    })->name('dashboard');

    Route::resource('properties', HostPropertyController::class)->except(['show']);
    Route::get('/properties/{property}', [HostPropertyController::class, 'show'])->name('properties.show');

    // Availability calendar. Registered after the resource routes; the
    // extra path segment keeps it from colliding with properties.show.
    Route::get('/properties/{property}/availability', [AvailabilityController::class, 'show'])
        ->name('properties.availability');
    Route::post('/properties/{property}/availability/toggle', [AvailabilityController::class, 'toggle'])
        ->name('properties.availability.toggle');

    // Razorpay subscription payments. Registered after the resource routes
    // for the same reason as availability: the extra path segment keeps
    // them clear of properties.show.
    Route::get('/properties/{property}/plans', [PaymentController::class, 'plans'])
        ->name('properties.plans');
    Route::post('/properties/{property}/order', [PaymentController::class, 'createOrder'])
        ->name('properties.order');
    Route::post('/properties/{property}/verify', [PaymentController::class, 'verify'])
        ->name('properties.verify');
    Route::get('/properties/{property}/failed', [PaymentController::class, 'failed'])
        ->name('properties.failed');
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
