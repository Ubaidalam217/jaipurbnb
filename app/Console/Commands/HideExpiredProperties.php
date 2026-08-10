<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Daily expiry sweep: takes listings off the public site once their
 * paid subscription window has passed - unless the host's Founding
 * Host promo (60 free days from registration, see
 * User::isFoundingHostActive()) is still covering them, in which case
 * the listing stays (or is brought) live for free.
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

    protected $description = 'Hide listings past subscription and Founding Host expiry; auto-publish approved listings still inside their Founding Host window';

    public function handle(): int
    {
        $today = now()->toDateString();
        $now   = now();

        // 1) Auto-publish: an approved listing not yet visible whose host
        // is still inside the Founding Host window goes live even though
        // it was never subscribed.
        $published = Property::query()
            ->where('listing_status', Property::STATUS_APPROVED)
            ->where('is_visible', false)
            ->whereHas('host', function ($query) use ($now) {
                $query->whereNotNull('founding_host_expires_at')
                    ->where('founding_host_expires_at', '>', $now);
            })
            ->update(['is_visible' => true]);

        // 2) Hide: approved, currently visible, subscription lapsed or
        // never paid, AND the Founding Host window also lapsed or was
        // never granted. A listing stays up as long as EITHER cover is
        // still active - subscription_expiry is a DATE column, so "<
        // today" means the last paid day is already over and a listing
        // expiring today stays up until tomorrow's run.
        $hidden = Property::query()
            ->where('listing_status', Property::STATUS_APPROVED)
            ->where('is_visible', true)
            ->where(function ($query) use ($today) {
                $query->whereNull('subscription_expiry')
                    ->orWhereDate('subscription_expiry', '<', $today);
            })
            ->whereDoesntHave('host', function ($query) use ($now) {
                $query->whereNotNull('founding_host_expires_at')
                    ->where('founding_host_expires_at', '>', $now);
            })
            ->update(['is_visible' => false]);

        Log::info('properties:hide-expired ran', [
            'date'            => $today,
            'hidden_count'    => $hidden,
            'published_count' => $published,
        ]);

        $this->info(
            "Published {$published} founding-host ".str('listing')->plural($published).
            "; hid {$hidden} expired ".str('listing')->plural($hidden).'.'
        );

        return self::SUCCESS;
    }
}
