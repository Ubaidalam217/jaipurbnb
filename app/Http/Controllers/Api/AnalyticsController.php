<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeadAnalytic;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Sink for navigator.sendBeacon() lead events fired from main.js
 * (WhatsApp click, Call click, property page view).
 *
 * sendBeacon has no response handler on the browser side, so there is
 * nothing to show a guest if this fails - every path returns 200. Bad
 * input is a silent no-op rather than a 4xx: a beacon that outlives its
 * property (guest kept a tab open while a listing expired or was
 * rejected) is expected traffic, not an error.
 */
class AnalyticsController extends Controller
{
    public function log(Request $request): JsonResponse
    {
        $propertyId = $request->input('property_id');
        $leadType = $request->input('lead_type');

        if (! is_numeric($propertyId) || ! in_array($leadType, LeadAnalytic::TYPES, true)) {
            return response()->json(['ok' => true]);
        }

        // Only count a lead against a listing a guest could actually see
        // when the click happened - keeps the dashboard from crediting
        // clicks logged against pending/rejected/expired listings.
        $visible = Property::query()
            ->whereKey((int) $propertyId)
            ->where('listing_status', Property::STATUS_APPROVED)
            ->where('is_visible', true)
            ->exists();

        if ($visible) {
            LeadAnalytic::create([
                'property_id' => (int) $propertyId,
                'lead_type'   => $leadType,
            ]);
        }

        return response()->json(['ok' => true]);
    }
}
