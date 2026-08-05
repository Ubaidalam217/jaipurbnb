<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Daily expiry sweep: takes listings off the public site once their
 * paid subscription window has passed.
 *
 * This only flips is_visible. It NEVER touches listing_status and
 * NEVER deletes anything - an expired listing stays
 * listing_status='approved' with all of its data intact, so a host
 * who renews goes straight back live without re-moderation.
 * See CLAUDE.md, "listing_status vs is_visible".
 *
 * Scheduled daily at 00:00 in routes/console.php. On Hostinger the
 * shared-hosting cron can also call this directly:
 *   php /home/USER/domains/jaipurbnb.com/artisan properties:hide-expired
 */
class HideExpiredProperties extends Command
{
    protected $signature = 'properties:hide-expired';

    protected $description = 'Hide listings whose subscription_expiry has passed (sets is_visible = false)';

    public function handle(): int
    {
        $today = now()->toDateString();

        // subscription_expiry is a DATE column. "< today" means the last
        // paid day is already over, so a listing expiring today stays up
        // until tomorrow's run.
        $hidden = Property::query()
            ->whereNotNull('subscription_expiry')
            ->whereDate('subscription_expiry', '<', $today)
            ->where('is_visible', true)
            ->update(['is_visible' => false]);

        Log::info('properties:hide-expired ran', [
            'date'         => $today,
            'hidden_count' => $hidden,
        ]);

        $this->info("Hid {$hidden} expired ".str('listing')->plural($hidden).'.');

        return self::SUCCESS;
    }
}
