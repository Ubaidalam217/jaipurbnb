<?php

namespace Database\Seeders;

use App\Models\Property;
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
 * Photos are remote picsum URLs rather than uploads, because Railway's
 * container filesystem is ephemeral and there is no volume mounted on the
 * web service, so anything written to storage/app/public vanishes on the
 * next deploy. PropertyImage::$display_url passes absolute URLs through
 * untouched while still running real uploads through Storage::url().
 *
 * Idempotent: keyed on host email and on (host_id, title), so re-running
 * on every container boot updates in place and never duplicates.
 */
class SamplePropertySeeder extends Seeder
{
    private const HOST_EMAIL = 'demohost@jaipurbnb.com';

    /**
     * neighborhood and stay_type values must match Property::NEIGHBORHOODS
     * and Property::STAY_TYPES exactly, or the browse filters silently
     * exclude the listing from their dropdowns.
     *
     * @var list<array{title: string, neighborhood: string, stay_type: string, price: int, description: string, image: string}>
     */
    private const PROPERTIES = [
        [
            'title'        => 'The Royal Walled City Haveli Room',
            'neighborhood' => 'Walled City',
            'stay_type'    => 'Heritage Haveli / Fort Stay',
            'price'        => 2500,
            'description'  => "A restored heritage haveli in the heart of Jaipur's Walled City, minutes from Hawa Mahal and Johari Bazaar.",
            'image'        => 'https://picsum.photos/seed/jaipur1/600/400',
        ],
        [
            'title'        => 'Premium Terrace Studio near Central Cafes',
            'neighborhood' => 'C-Scheme',
            'stay_type'    => 'Boutique Apartment',
            'price'        => 3800,
            'description'  => 'Modern studio apartment in upscale C-Scheme, walking distance to trendy cafes and restaurants.',
            'image'        => 'https://picsum.photos/seed/jaipur2/600/400',
        ],
        [
            'title'        => 'Aravali Hills View Family Escape',
            'neighborhood' => 'Delhi Road',
            'stay_type'    => 'Luxury Villa / Farmhouse',
            'price'        => 6500,
            'description'  => 'Spacious family villa with stunning Aravali hills views, perfect for large groups and events.',
            'image'        => 'https://picsum.photos/seed/jaipur3/600/400',
        ],
        [
            'title'        => 'Cozy Amer Fort View Homestay',
            'neighborhood' => 'Amer',
            'stay_type'    => 'Homestay / Guest House',
            'price'        => 1800,
            'description'  => 'Charming homestay with direct views of Amer Fort, experience authentic Rajasthani hospitality.',
            'image'        => 'https://picsum.photos/seed/jaipur4/600/400',
        ],
        [
            'title'        => 'Bani Park Boutique Getaway',
            'neighborhood' => 'Bani Park',
            'stay_type'    => 'Boutique Apartment',
            'price'        => 3200,
            'description'  => 'Elegant boutique stay in peaceful Bani Park, close to the railway station and city center.',
            'image'        => 'https://picsum.photos/seed/jaipur5/600/400',
        ],
        [
            'title'        => 'Nahargarh Heritage Retreat',
            'neighborhood' => 'Nahargarh',
            'stay_type'    => 'Heritage Haveli / Fort Stay',
            'price'        => 5500,
            'description'  => 'Heritage retreat near Nahargarh Fort with rooftop terrace and panoramic city views.',
            'image'        => 'https://picsum.photos/seed/jaipur6/600/400',
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
            $property->listing_status      = Property::STATUS_APPROVED;
            $property->is_verified         = true;
            $property->is_visible          = true;
            $property->subscription_expiry = now()->addYear();
            $property->save();

            // One cover photo per listing. Keying on is_cover means a rerun
            // rewrites the existing cover rather than stacking duplicates.
            $image = PropertyImage::firstOrNew([
                'property_id' => $property->id,
                'is_cover'    => true,
            ]);

            $image->image_url = $definition['image'];
            $image->save();
        }

        $this->command->info(sprintf(
            'Sample properties ready: %d listings under %s',
            count(self::PROPERTIES),
            self::HOST_EMAIL
        ));
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

        $host->name         = 'Demo Host';
        $host->phone_number = '9876543210';
        $host->password     = 'demohost123'; // hashed by the model cast
        $host->role         = User::ROLE_HOST;
        $host->save();

        return $host;
    }
}
