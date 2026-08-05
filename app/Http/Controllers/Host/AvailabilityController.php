<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyAvailability;
use App\Support\AvailabilityCalendar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Host-facing availability calendar: view the next three months and
 * block/unblock individual dates.
 *
 * OWNERSHIP: like Host\PropertyController, a listing belonging to
 * someone else 404s rather than 403s - a 403 would confirm the id exists.
 *
 * SOURCE OF TRUTH: this controller only ever writes source='manual'
 * rows. Dates owned by the Airbnb feed (source='airbnb_sync') are
 * rendered but rejected on toggle, so the upcoming iCal sync can keep
 * replacing its own rows without fighting the host.
 */
class AvailabilityController extends Controller
{
    public function show(Property $property): View
    {
        $property = $this->ownedOrFail($property);

        return view('host.properties.availability', [
            'property' => $property,
            'calendar' => AvailabilityCalendar::build($property),
        ]);
    }

    /**
     * Flip one date between available and blocked.
     *
     * Always returns JSON: this is only ever called from fetch() on the
     * calendar page.
     */
    public function toggle(Request $request, Property $property): JsonResponse
    {
        $property = $this->ownedOrFail($property);

        $validated = $request->validate([
            // after_or_equal:today lets a host block today itself but not
            // rewrite history - past cells are non-interactive in the UI,
            // so anything earlier is a crafted request.
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        $date = $validated['date'];
        $record = $property->availability()->firstOrNew(['calendar_date' => $date]);

        if ($record->exists && AvailabilityCalendar::isLocked($record->status, $record->source)) {
            return response()->json([
                'ok'      => false,
                'message' => $record->source === PropertyAvailability::SOURCE_AIRBNB
                    ? 'This date is blocked by your Airbnb calendar and cannot be changed here.'
                    : 'This date is booked and cannot be changed here.',
            ], 422);
        }

        if (! $record->exists) {
            // No row means the date was available by default, so the first
            // click blocks it.
            $record->status = PropertyAvailability::STATUS_BLOCKED;
            $record->source = PropertyAvailability::SOURCE_MANUAL;
        } else {
            $record->status = $record->status === PropertyAvailability::STATUS_BLOCKED
                ? PropertyAvailability::STATUS_AVAILABLE
                : PropertyAvailability::STATUS_BLOCKED;
        }

        $record->save();

        return response()->json([
            'ok'      => true,
            'date'    => $date,
            'status'  => $record->status,
            'blocked' => $record->status !== PropertyAvailability::STATUS_AVAILABLE,
        ]);
    }

    /* ------------------------------------------------------------------ */

    /**
     * 404 unless the listing belongs to the signed-in host.
     * Mirrors Host\PropertyController::ownedOrFail().
     */
    private function ownedOrFail(Property $property): Property
    {
        abort_unless($property->host_id === auth()->id(), 404);

        return $property;
    }
}
