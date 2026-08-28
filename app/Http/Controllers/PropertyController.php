<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Support\AvailabilityCalendar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Public, unauthenticated property browsing.
 *
 * VISIBILITY RULE - the single gate for everything a guest can see:
 *   listing_status = 'approved'  AND  is_visible = true
 * Both must hold. 'approved' alone is not enough: the daily
 * properties:hide-expired sweep flips is_visible off when a
 * subscription lapses while leaving listing_status untouched.
 *
 * Query parameters are sanitised, never validated. A bad ?neighborhood=
 * on a public URL should quietly fall back to "no filter", not bounce a
 * guest to an error page - these values arrive from bookmarks, shared
 * links and crawlers as much as from our own form.
 */
class PropertyController extends Controller
{
    private const PER_PAGE = 9;

    /**
     * Offered values for the two capacity dropdowns, both read as
     * "n or more". Kept as allow-lists so a crafted ?guests=999 is
     * treated as "no filter" rather than silently returning nothing.
     */
    public const GUEST_OPTIONS = [1, 2, 4, 6, 8];
    public const BEDROOM_OPTIONS = [1, 2, 3, 4];

    /** Query-param value => ORDER BY clause. */
    private const SORTS = [
        'newest'     => ['created_at', 'desc'],
        'price_low'  => ['approx_price', 'asc'],
        'price_high' => ['approx_price', 'desc'],
    ];

    public function index(Request $request): View
    {
        $filters = $this->filters($request);

        $properties = $this->visible()
            ->with(['coverImage', 'host'])
            ->when($filters['neighborhood'], fn (Builder $q, $v) => $q->where('neighborhood', $v))
            ->when($filters['stay_type'], fn (Builder $q, $v) => $q->where('stay_type', $v))
            ->when($filters['min_price'] !== null, fn (Builder $q) => $q->where('approx_price', '>=', $filters['min_price']))
            ->when($filters['max_price'] !== null, fn (Builder $q) => $q->where('approx_price', '<=', $filters['max_price']))
            ->when($filters['guests'] !== null, fn (Builder $q) => $q->where('max_guests', '>=', $filters['guests']))
            ->when($filters['bedrooms'] !== null, fn (Builder $q) => $q->where('bedrooms', '>=', $filters['bedrooms']))
            ->orderBy(...self::SORTS[$filters['sort']])
            // Tie-break so paginated pages never repeat or drop a row when
            // several listings share a price / timestamp.
            ->orderBy('id', 'desc')
            ->paginate(self::PER_PAGE)
            // Keep the active filters on every pagination link.
            ->withQueryString();

        return view('apartment.v4', [
            'properties'    => $properties,
            'filters'       => $filters,
            // The filter dropdown lists every neighborhood a host MAY pick.
            // The header counter is coverage - neighborhoods that actually
            // have a live listing - so it is a query, not count() of the
            // constant. Both this and the homepage read the same method.
            'neighborhoods' => Property::NEIGHBORHOODS,
            'neighborhoodCount' => Property::liveNeighborhoodCount(),
            'stayTypes'     => Property::STAY_TYPES,
            'guestOptions'  => self::GUEST_OPTIONS,
            'bedroomOptions' => self::BEDROOM_OPTIONS,
            'sorts'         => array_keys(self::SORTS),
        ]);
    }

    public function show(int $id): View
    {
        /** @var Property $property */
        $property = $this->visible()
            ->with(['images', 'host'])
            ->findOrFail($id);

        // Fill the "latest listings" carousel with other live listings
        // rather than the template's hardcoded demo cards.
        $related = $this->visible()
            ->with('coverImage')
            ->whereKeyNot($property->id)
            ->latest()
            ->limit(6)
            ->get();

        return view('single.index5', [
            'property' => $property,
            'related'  => $related,
            // Read-only 3-month view. Dates with no availability row are
            // available by default, so this is populated for every listing.
            'calendar' => AvailabilityCalendar::build($property),
        ]);
    }

    /* ------------------------------------------------------------------ */

    /**
     * Base query for anything a guest is allowed to see.
     */
    private function visible(): Builder
    {
        return Property::query()
            ->where('listing_status', Property::STATUS_APPROVED)
            ->where('is_visible', true);
    }

    /**
     * Coerce query params into a safe, fully-populated filter set.
     * Unrecognised values become null (= filter off).
     *
     * @return array{neighborhood: ?string, stay_type: ?string, min_price: ?int, max_price: ?int, guests: ?int, bedrooms: ?int, sort: string}
     */
    private function filters(Request $request): array
    {
        $min = $this->positiveInt($request->query('min_price'));
        $max = $this->positiveInt($request->query('max_price'));

        // A reversed range would silently return zero results and read as
        // "we have nothing", so treat it as the range the guest meant.
        if ($min !== null && $max !== null && $min > $max) {
            [$min, $max] = [$max, $min];
        }

        $sort = $request->query('sort');

        return [
            'neighborhood' => $this->oneOf($request->query('neighborhood'), Property::NEIGHBORHOODS),
            'stay_type'    => $this->oneOf($request->query('stay_type'), Property::STAY_TYPES),
            'min_price'    => $min,
            'max_price'    => $max,
            // Capacity filters are "n or more". Anything not on the offered
            // list falls back to null (= no filter), same as every other
            // param here: a junk value must not bounce a guest to an error.
            'guests'       => $this->oneOfInt($request->query('guests'), self::GUEST_OPTIONS),
            'bedrooms'     => $this->oneOfInt($request->query('bedrooms'), self::BEDROOM_OPTIONS),
            'sort'         => is_string($sort) && isset(self::SORTS[$sort]) ? $sort : 'newest',
        ];
    }

    /**
     * @param  list<string>  $allowed
     */
    private function oneOf(mixed $value, array $allowed): ?string
    {
        return is_string($value) && in_array($value, $allowed, true) ? $value : null;
    }

    /**
     * Same idea as oneOf() but for the numeric capacity filters.
     *
     * @param  list<int>  $allowed
     */
    private function oneOfInt(mixed $value, array $allowed): ?int
    {
        $int = $this->positiveInt($value);

        return $int !== null && in_array($int, $allowed, true) ? $int : null;
    }

    private function positiveInt(mixed $value): ?int
    {
        if (! is_string($value) && ! is_int($value)) {
            return null;
        }

        // ctype_digit rejects "1e3", "-5", "12.5" and " 12" - all of which
        // (int) would happily mangle into something the guest never typed.
        $value = (string) $value;

        return $value !== '' && ctype_digit($value) ? (int) $value : null;
    }
}
