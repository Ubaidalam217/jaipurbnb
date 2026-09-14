<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

/**
 * The client's fixed amenity list, grouped the same way Airbnb groups
 * them (basics / popular / features), plus an empty "location" category
 * reserved for later.
 *
 * Idempotent on name (amenities.name is unique) - firstOrCreate() means
 * re-running never duplicates a row, so this is safe in the same deploy
 * start command as AdminSeeder / SamplePropertySeeder.
 */
class AmenitySeeder extends Seeder
{
    /**
     * @var list<array{name: string, category: string, icon: string}>
     */
    private const AMENITIES = [
        // Basics
        ['name' => 'Air conditioning', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-wind'],
        ['name' => 'Essentials', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-suitcase'],
        ['name' => 'Fridge', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-box'],
        ['name' => 'Heating', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-fire'],
        ['name' => 'Hot water', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-droplet'],
        ['name' => 'Kitchen', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-kitchen-set'],
        ['name' => 'TV', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-tv'],
        ['name' => 'Tumble dryer', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-shirt'],
        ['name' => 'Washing machine', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-soap'],
        ['name' => 'Wifi', 'category' => Amenity::CATEGORY_BASICS, 'icon' => 'fa-solid fa-wifi'],

        // Popular
        ['name' => 'Coffee maker', 'category' => Amenity::CATEGORY_POPULAR, 'icon' => 'fa-solid fa-mug-hot'],
        ['name' => 'Cooking basics', 'category' => Amenity::CATEGORY_POPULAR, 'icon' => 'fa-solid fa-utensils'],
        ['name' => 'Hairdryer', 'category' => Amenity::CATEGORY_POPULAR, 'icon' => 'fa-solid fa-fan'],
        ['name' => 'Hangers', 'category' => Amenity::CATEGORY_POPULAR, 'icon' => 'fa-solid fa-shirt'],
        ['name' => 'Iron', 'category' => Amenity::CATEGORY_POPULAR, 'icon' => 'fa-solid fa-temperature-high'],
        ['name' => 'Shampoo', 'category' => Amenity::CATEGORY_POPULAR, 'icon' => 'fa-solid fa-pump-soap'],

        // Features
        ['name' => 'Cot', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-bed'],
        ['name' => 'Dedicated workspace', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-laptop'],
        ['name' => 'EV charger', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-charging-station'],
        ['name' => 'Free parking', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-square-parking'],
        ['name' => 'Gym', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-dumbbell'],
        ['name' => 'Hot tub', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-hot-tub-person'],
        ['name' => 'Indoor fireplace', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-fire-flame-curved'],
        ['name' => 'Outdoor furniture', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-chair'],
        ['name' => 'Pool', 'category' => Amenity::CATEGORY_FEATURES, 'icon' => 'fa-solid fa-person-swimming'],

        // Location - intentionally empty for now, per the client's list.
    ];

    public function run(): void
    {
        foreach (self::AMENITIES as $amenity) {
            Amenity::firstOrCreate(
                ['name' => $amenity['name']],
                ['category' => $amenity['category'], 'icon' => $amenity['icon']]
            );
        }

        $this->command->info(sprintf('Amenities ready: %d.', count(self::AMENITIES)));
    }
}
