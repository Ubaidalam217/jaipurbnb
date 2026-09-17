<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Property;
use App\Models\PropertyAvailability;
use App\Models\PropertyImage;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Demo content for the client walkthrough: one host and six live listings
 * so /browse is not an empty state.
 *
 * These rows satisfy the public visibility gate documented on
 * PropertyController: listing_status = 'approved' AND is_visible = true.
 * Both are required - 'approved' alone renders nothing.
 *
 * Photos are root-relative paths into public/img, NOT uploads: Railway's
 * container filesystem is ephemeral with no volume mounted on the web
 * service, so anything written to storage/app/public vanishes on the next
 * deploy. PropertyImage::$display_url passes a leading-slash path through
 * untouched while still running real uploads through Storage::url().
 *
 * These were previously remote picsum.photos URLs. Picsum had a global
 * outage that blanked every listing image on production, and it serves
 * random stock - the browse page was showing Lisbon trams on a site that
 * sells Jaipur stays. Production was patched as data only at the time, which
 * meant re-running this seeder silently reverted it; these local paths are
 * the permanent fix. Do not reintroduce a remote image host here.
 *
 * Idempotent: keyed on host email and on (host_id, title), so re-running
 * on every container boot updates in place and never duplicates.
 */
class SamplePropertySeeder extends Seeder
{
    private const HOST_EMAIL = 'demohost@jaipurbnb.com';
    private const HOST_PHONE = '9876543210';

    /**
     * neighborhood and stay_type values must match Property::NEIGHBORHOODS
     * and Property::STAY_TYPES exactly, or the browse filters silently
     * exclude the listing from their dropdowns.
     *
     * Capacities are spread deliberately (guests 2-8, bedrooms 1-4) so the
     * browse "Guests" and "Bedrooms" filters visibly narrow the results
     * during a demo rather than always returning all six.
     *
     * @var list<array{title: string, neighborhood: string, stay_type: string, price: int, guests: int, bedrooms: int, bathrooms: int, description: string, image: string}>
     */
    private const PROPERTIES = [
        [
            'title'        => 'The Royal Walled City Haveli Room',
            'neighborhood' => 'Walled City',
            'stay_type'    => 'Heritage Haveli / Fort Stay',
            'price'        => 2500,
            'guests'       => 4,
            'bedrooms'     => 2,
            'bathrooms'    => 2,
            'description'  => "A restored heritage haveli in the heart of Jaipur's Walled City, minutes from Hawa Mahal and Johari Bazaar. Hand-painted frescoes, a marble courtyard and a rooftop that looks straight out over the old city.",
            'image'        => '/img/all-images/hero/hero-img6-1200w.webp',

            // This is the client's designated reference listing, so it is the
            // one seeded complete: address + coordinates for the map embed,
            // a photo gallery rather than a lone cover, amenities, and a
            // calendar with real blocked/booked dates. The other five stay
            // deliberately sparse - they exist to populate /browse and to
            // give the filters something to narrow.
            'reference'    => true,
            'address'      => 'Gangauri Bazaar, near Tripolia Gate, Walled City',
            'pincode'      => '302002',
            'latitude'     => 26.9239,   // Hawa Mahal / Tripolia Bazaar area
            'longitude'    => 75.8267,
            'pet_friendly' => true,
            // Chosen so none of these is also a cover on another listing -
            // the same photo appearing twice in a six-item demo set is the
            // kind of thing a client spots immediately.
            'gallery'      => [
                '/img/all-images/apartment/apartment-img3.webp',
                '/img/all-images/apartment/apartment-img5.webp',
                '/img/all-images/service/service-img4.webp',
                '/img/all-images/service/service-img7.webp',
            ],
            // These MUST match AmenitySeeder's names exactly - they are looked
            // up by name, and anything unmatched is skipped rather than
            // created, so a typo silently yields a shorter amenity list.
            'amenities'    => [
                'Wifi', 'Air conditioning', 'Kitchen', 'Free parking',
                'Hot water', 'Pool', 'Essentials', 'Cooking basics',
                'Outdoor furniture', 'Hairdryer',
            ],
        ],
        [
            'title'        => 'Premium Terrace Studio near Central Cafes',
            'neighborhood' => 'C-Scheme',
            'stay_type'    => 'Boutique Apartment',
            'price'        => 3800,
            'guests'       => 2,
            'bedrooms'     => 1,
            'bathrooms'    => 1,
            'description'  => 'Modern studio apartment in upscale C-Scheme, walking distance to trendy cafes and restaurants.',
            'image'        => '/img/all-images/property/property-img5.webp',
            'address'      => 'Ashok Marg, C-Scheme',
            'pincode'      => '302001',
            'latitude'     => 26.9048,
            'longitude'    => 75.7905,
        ],
        [
            'title'        => 'Aravali Hills View Family Escape',
            'neighborhood' => 'Delhi Road',
            'stay_type'    => 'Luxury Villa / Farmhouse',
            'price'        => 6500,
            'guests'       => 8,
            'bedrooms'     => 4,
            'bathrooms'    => 3,
            'description'  => 'Spacious family villa with stunning Aravali hills views, perfect for large groups and events.',
            'image'        => '/img/all-images/property/property-img4.webp',
            'address'      => 'Kukas, Delhi Road',
            'pincode'      => '303101',
            'latitude'     => 27.0448,
            'longitude'    => 75.8702,
        ],
        [
            'title'        => 'Cozy Amer Fort View Homestay',
            'neighborhood' => 'Amer',
            'stay_type'    => 'Homestay / Guest House',
            'price'        => 1800,
            'guests'       => 3,
            'bedrooms'     => 1,
            'bathrooms'    => 1,
            'description'  => 'Charming homestay with direct views of Amer Fort, experience authentic Rajasthani hospitality.',
            'image'        => '/img/all-images/hero/hero-img1-1200w.webp',
            'address'      => 'Near Amer Fort, Amer',
            'pincode'      => '302028',
            'latitude'     => 26.9855,
            'longitude'    => 75.8513,
        ],
        [
            'title'        => 'Bani Park Boutique Getaway',
            'neighborhood' => 'Bani Park',
            'stay_type'    => 'Boutique Apartment',
            'price'        => 3200,
            'guests'       => 4,
            'bedrooms'     => 2,
            'bathrooms'    => 2,
            'description'  => 'Elegant boutique stay in peaceful Bani Park, close to the railway station and city center.',
            'image'        => '/img/all-images/apartment/apartment-img2.webp',
            'address'      => 'Kabir Marg, Bani Park',
            'pincode'      => '302016',
            'latitude'     => 26.9312,
            'longitude'    => 75.7961,
        ],
        [
            'title'        => 'Nahargarh Heritage Retreat',
            'neighborhood' => 'Nahargarh',
            'stay_type'    => 'Heritage Haveli / Fort Stay',
            'price'        => 5500,
            'guests'       => 6,
            'bedrooms'     => 3,
            'bathrooms'    => 3,
            'description'  => 'Heritage retreat near Nahargarh Fort with rooftop terrace and panoramic city views.',
            'image'        => '/img/all-images/hero/hero-img5-1200w.webp',
            'address'      => 'Nahargarh Fort Road',
            'pincode'      => '302002',
            'latitude'     => 26.9374,
            'longitude'    => 75.8154,
        ],
    ];

    public function run(): void
    {
        $host = $this->demoHost();

        foreach (self::PROPERTIES as $definition) {
            // Keyed on (host_id, title) so a second run updates the same
            // row instead of inserting a seventh, eighth, ... listing.
            $property = Property::firstOrNew([
                'host_id' => $host->id,
                'title'   => $definition['title'],
            ]);

            $property->description         = $definition['description'];
            $property->neighborhood        = $definition['neighborhood'];
            $property->stay_type           = $definition['stay_type'];
            $property->approx_price        = $definition['price'];
            $property->max_guests          = $definition['guests'];
            $property->bedrooms            = $definition['bedrooms'];
            $property->bathrooms           = $definition['bathrooms'];
            $property->listing_status      = Property::STATUS_APPROVED;
            $property->is_verified         = true;
            $property->is_visible          = true;
            $property->subscription_expiry = now()->addYear();

            // Every listing this seeder creates is sample content, and the
            // public card/detail views key their "Demo listing" badge off
            // this. Without it a guest cannot tell seeded content from a real
            // host's property, and the demo host's WhatsApp line is live.
            $property->is_demo = true;

            // Optional richness, only present on the reference listing.
            $property->full_address    = $definition['address'] ?? null;
            $property->pincode         = $definition['pincode'] ?? null;
            $property->latitude        = $definition['latitude'] ?? null;
            $property->longitude       = $definition['longitude'] ?? null;
            $property->is_pet_friendly = $definition['pet_friendly'] ?? false;

            $property->save();

            // One cover photo per listing. Keying on is_cover means a rerun
            // rewrites the existing cover rather than stacking duplicates.
            $image = PropertyImage::firstOrNew([
                'property_id' => $property->id,
                'is_cover'    => true,
            ]);

            $image->image_url = $definition['image'];
            $image->save();

            $this->syncGallery($property, $definition['gallery'] ?? []);
            $this->syncAmenities($property, $definition['amenities'] ?? []);

            if ($definition['reference'] ?? false) {
                $this->seedCalendar($property);
            }
        }

        $this->command->info(sprintf(
            'Sample properties ready: %d listings under %s',
            count(self::PROPERTIES),
            self::HOST_EMAIL
        ));
    }

    /**
     * Non-cover gallery photos.
     *
     * Local paths under public/img rather than picsum: picsum had a global
     * outage that blanked every listing image on production, and these are
     * template assets that ship with the repo. PropertyImage::$display_url
     * passes a leading-slash path straight through.
     *
     * Deletes the existing non-cover rows first so a rerun replaces the
     * gallery instead of appending a second copy of it.
     *
     * @param  list<string>  $paths
     */
    private function syncGallery(Property $property, array $paths): void
    {
        if ($paths === []) {
            return;
        }

        PropertyImage::where('property_id', $property->id)
            ->where('is_cover', false)
            ->delete();

        foreach ($paths as $path) {
            PropertyImage::create([
                'property_id' => $property->id,
                'image_url'   => $path,
                'is_cover'    => false,
            ]);
        }
    }

    /**
     * Attach amenities by name.
     *
     * sync() (not attach) so a rerun converges rather than tripping the
     * unique(property_id, amenity_id) index. Names are looked up, never
     * created - AmenitySeeder owns that list, and inventing rows here would
     * put an amenity in the browse filter that no real host can pick.
     *
     * @param  list<string>  $names
     */
    private function syncAmenities(Property $property, array $names): void
    {
        if ($names === []) {
            return;
        }

        $ids = Amenity::whereIn('name', $names)->pluck('id');

        $property->amenities()->sync($ids);

        $missing = count($names) - $ids->count();

        if ($missing > 0) {
            $this->command->warn(sprintf(
                '%d amenity name(s) on "%s" did not match AmenitySeeder and were skipped.',
                $missing,
                $property->title
            ));
        }
    }

    /**
     * A calendar with something actually on it.
     *
     * A listing with no availability rows renders as fully available (dates
     * default to available - see AvailabilityCalendar), so the reference page
     * would show an empty three-month grid and the client could not tell the
     * calendar was working. This blocks a short mid-month window and books a
     * weekend so both states are visible.
     *
     * Dates are relative to today and updateOrCreate'd against the
     * unique(property_id, calendar_date) index, so reseeding later still
     * lands on future dates rather than leaving the demo in the past.
     */
    private function seedCalendar(Property $property): void
    {
        $blocked = [5, 6, 7, 8];          // days from today
        $booked  = [14, 15, 16, 21, 22];

        foreach ([PropertyAvailability::STATUS_BLOCKED => $blocked, PropertyAvailability::STATUS_BOOKED => $booked] as $status => $offsets) {
            foreach ($offsets as $offset) {
                PropertyAvailability::updateOrCreate(
                    [
                        'property_id'   => $property->id,
                        'calendar_date' => now()->addDays($offset)->toDateString(),
                    ],
                    [
                        'status' => $status,
                        'source' => PropertyAvailability::SOURCE_MANUAL,
                    ]
                );
            }
        }
    }

    /**
     * The demo host owning every sample listing.
     *
     * role is deliberately not mass-assignable on User, so it is set
     * explicitly here - the same approach AdminSeeder uses.
     */
    private function demoHost(): User
    {
        $host = User::firstOrNew(['email' => self::HOST_EMAIL]);

        $host->name = 'Demo Host';

        // The demo host MUST end up with a phone number: contact-buttons
        // renders "Contact info unavailable" without one, which is exactly
        // the thing a client demo must not show. phone_number is UNIQUE
        // though, so claim the canonical number when it is free and walk to
        // the next variant when some other account already holds it - never
        // leave it null, and never let a collision abort the seeder (the
        // deploy start command chains seeding with && before booting the
        // web server, so a failure here takes the site down).
        $host->phone_number = $host->phone_number ?: $this->freePhone(self::HOST_PHONE, self::HOST_EMAIL);

        $host->password = 'demohost123'; // hashed by the model cast
        $host->role     = User::ROLE_HOST;
        $host->save();

        return $host;
    }

    /**
     * The preferred phone number, or the next free variant of it.
     */
    private function freePhone(string $preferred, string $email): ?string
    {
        $candidate = $preferred;

        for ($i = 1; $i <= 50; $i++) {
            $owner = User::where('phone_number', $candidate)->first();

            if (! $owner || $owner->email === $email) {
                return $candidate;
            }

            $candidate = substr($preferred, 0, -1).$i;
        }

        // Repeated NULLs do not collide under a UNIQUE index, so seeding
        // still succeeds - the card just falls back to its no-contact state.
        return null;
    }
}
