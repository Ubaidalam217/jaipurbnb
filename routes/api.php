<?php

use App\Http\Controllers\Api\AnalyticsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
| Prefixed with /api and stateless (no session, no CSRF) - see the
| 'api' middleware group in bootstrap/app.php. This keeps it reachable
| from navigator.sendBeacon(), which cannot attach a CSRF header.
*/

Route::post('/analytics/log', [AnalyticsController::class, 'log']);
