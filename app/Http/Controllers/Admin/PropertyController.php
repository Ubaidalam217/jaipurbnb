<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Admin moderation queue.
 *
 * Approving sets listing_status = approved and is_verified = true.
 * Visibility is normally driven by the subscription: the Milestone 3
 * payment flow turns is_visible on and the daily expiry cron turns it
 * back off. The one exception is a host still inside their Founding
 * Host trial (see User::isFoundingHostActive()) - approve() publishes
 * those immediately rather than waiting for the next
 * properties:hide-expired run, which only sweeps once a day and left
 * newly-approved Founding Host listings invisible until midnight.
 */
class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->query('status', Property::STATUS_PENDING);

        if (! in_array($filter, [...Property::STATUSES, 'all'], true)) {
            $filter = Property::STATUS_PENDING;
        }

        $properties = Property::query()
            ->with(['host', 'coverImage'])
            ->when($filter !== 'all', fn ($q) => $q->where('listing_status', $filter))
            ->latest()
            ->get();

        $counts = [
            Property::STATUS_PENDING  => Property::where('listing_status', Property::STATUS_PENDING)->count(),
            Property::STATUS_APPROVED => Property::where('listing_status', Property::STATUS_APPROVED)->count(),
            Property::STATUS_REJECTED => Property::where('listing_status', Property::STATUS_REJECTED)->count(),
            'all'                     => Property::count(),
        ];

        return view('admin.properties.index', compact('properties', 'filter', 'counts'));
    }

    public function show(Property $property): View
    {
        $property->load(['host', 'images']);

        return view('admin.properties.show', compact('property'));
    }

    public function approve(Property $property): RedirectResponse
    {
        $property->loadMissing('host');

        $property->update([
            'listing_status'   => Property::STATUS_APPROVED,
            'is_verified'      => true,
            'rejection_reason' => null,
            // Publish immediately if the host's Founding Host trial is
            // still active, instead of leaving it invisible until the
            // next daily properties:hide-expired sweep. Otherwise leave
            // is_visible exactly as it was - see class docblock.
            'is_visible'       => $property->is_visible || $property->host->isFoundingHostActive(),
        ]);

        return redirect()->route('admin.properties.index')
            ->with('status', '“'.$property->title.'” approved.');
    }

    public function reject(Request $request, Property $property): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $property->update([
            'listing_status'   => Property::STATUS_REJECTED,
            'is_verified'      => false,
            'is_visible'       => false,
            'rejection_reason' => $validated['rejection_reason'] ?? null,
        ]);

        return redirect()->route('admin.properties.index')
            ->with('status', '“'.$property->title.'” rejected.');
    }
}
