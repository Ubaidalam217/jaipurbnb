<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled tasks
|--------------------------------------------------------------------------
| Laravel 12 registers the scheduler here, not in a Console\Kernel.
| Requires ONE system cron entry on the server:
|   * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
|
| If Hostinger's panel will not run a per-minute cron, drop the
| scheduler and point a daily 00:00 cron straight at
| `php artisan properties:hide-expired` instead - the command is
| self-contained and safe to run on its own.
*/

// Take expired listings off the public site at midnight server time.
// withoutOverlapping() guards against a slow run colliding with the next.
Schedule::command('properties:hide-expired')
    ->dailyAt('00:00')
    ->withoutOverlapping();
