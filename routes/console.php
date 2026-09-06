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

/*
| IMPORTANT - why these use Schedule::call() and not Schedule::command()
|
| Hostinger shared hosting disables proc_open() (see `disable_functions` in
| the alt-php83 ini). Schedule::command() ALWAYS spawns the artisan command
| as a child process via Symfony's Process class, which needs proc_open -
| so every scheduled run died with:
|
|   The Process class relies on proc_open, which is not available on your
|   PHP installation.
|
| ->runInBackground() made it worse but was not the cause; dropping it alone
| does not help. Schedule::call() invokes the command in-process through
| Artisan::call(), so no subprocess is forked and the scheduler works.
|
| ->name(...) is required before ->withoutOverlapping() on a callback event,
| since the mutex key is derived from the name rather than the command line.
*/

// Take expired listings off the public site at midnight server time.
Schedule::call(fn () => Artisan::call('properties:hide-expired'))
    ->name('properties:hide-expired')
    ->dailyAt('00:00')
    ->withoutOverlapping();

// Pull Airbnb .ics feeds and block booked dates (one-way, never pushes back).
// Every 30 minutes per the agreed scope. withoutOverlapping() guards against
// a slow external feed letting the next tick start on top of this one.
Schedule::call(fn () => Artisan::call('ical:sync'))
    ->name('ical:sync')
    ->everyThirtyMinutes()
    ->withoutOverlapping();
