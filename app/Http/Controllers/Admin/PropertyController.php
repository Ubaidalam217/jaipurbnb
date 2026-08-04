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
 * Approving sets listing_status = approved and is_verified = true, but
 * deliberately does NOT touch is_visible. Visibility is driven by the
 * subscription: the Milestone 3 payment flow turns it on and the daily
 * expiry cron turns it back off. Conflating the two would publish
 * unpaid listings.
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
        $property->update([
            'listing_status'   => Property::STATUS_APPROVED,
            'is_verified'      => true,
            'rejection_reason' => null,
            // is_visible intentionally untouched - see class docblock.
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
