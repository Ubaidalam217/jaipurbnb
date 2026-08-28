<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\PropertyAvailability;
use App\Services\ICalSyncService;
use Illuminate\Console\Command;

/**
 * Pulls every configured Airbnb .ics feed and blocks the dates it contains.
 *
 * Scheduled every 30 minutes in routes/console.php. Safe to run by hand at
 * any time - the sync is idempotent, so a manual run between scheduled ones
 * simply brings the calendar up to date early.
 *
 * Exits 0 even when individual feeds fail. A dead URL on one listing is an
 * expected, recoverable condition, not a reason for the scheduler to start
 * reporting the whole job as broken.
 */
class SyncICalFeeds extends Command
{
    protected $signature = 'ical:sync
                            {--property= : Sync a single property by id instead of all}';

    protected $description = 'Pull external calendar / iCal feeds and block booked dates (one-way)';

    public function handle(ICalSyncService $sync): int
    {
        $single = $this->option('property');

        if ($single !== null) {
            return $this->syncOne($sync, (int) $single);
        }

        // Must mirror ICalSyncService::syncAll(): listings with a feed, plus
        // any still carrying airbnb_sync rows after their feed was removed,
        // which need those dates released. Counting only the former made the
        // header disagree with the results table.
        $inScope = Property::query()
            ->where(function ($query) {
                $query
                    ->where(fn ($q) => $q->whereNotNull('ical_feed_url')->where('ical_feed_url', '!=', ''))
                    ->orWhereHas('availability', fn ($q) => $q->where('source', PropertyAvailability::SOURCE_AIRBNB));
            })
            ->count();

        if ($inScope === 0) {
            $this->components->info('No listings have an iCal feed configured. Nothing to do.');

            return self::SUCCESS;
        }

        $this->components->info("Syncing {$inScope} ".str('listing')->plural($inScope).'…');

        $totals = $sync->syncAll();

        $this->newLine();
        $this->table(
            ['Listings', 'Succeeded', 'Failed', 'Dates blocked', 'Dates freed'],
            [[
                $totals['properties'],
                $totals['succeeded'],
                $totals['failed'],
                $totals['blocked'],
                $totals['removed'],
            ]]
        );

        if ($totals['failed'] > 0) {
            $this->components->warn(
                $totals['failed'].' '.str('feed')->plural($totals['failed']).
                ' could not be synced. See the log for details.'
            );
        }

        return self::SUCCESS;
    }

    private function syncOne(ICalSyncService $sync, int $id): int
    {
        $property = Property::find($id);

        if (! $property) {
            $this->components->error("No property with id {$id}.");

            return self::FAILURE;
        }

        $this->components->info("Syncing “{$property->title}”…");

        $result = $sync->syncProperty($property);

        if (! $result['synced']) {
            $this->components->warn('Not synced: '.($result['reason'] ?? 'unknown reason'));

            return self::SUCCESS;
        }

        $this->components->info(
            "Blocked {$result['blocked']} ".str('date')->plural($result['blocked']).
            ", freed {$result['removed']}."
        );

        return self::SUCCESS;
    }
}
