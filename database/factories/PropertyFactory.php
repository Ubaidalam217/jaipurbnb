<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    protected $model = Property::class;

    /**
     * Default state mirrors a freshly submitted listing: pending
     * moderation and not on the public site.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'host_id'             => User::factory()->state(['role' => User::ROLE_HOST]),
            'title'               => fake()->streetName().' Stay',
            'description'         => fake()->paragraph(),
            'neighborhood'        => fake()->randomElement(Property::NEIGHBORHOODS),
            'stay_type'           => fake()->randomElement(Property::STAY_TYPES),
            'approx_price'        => fake()->numberBetween(800, 25000),
            'max_guests'          => fake()->numberBetween(2, 8),
            'bedrooms'            => fake()->numberBetween(1, 4),
            'bathrooms'           => fake()->numberBetween(1, 3),
            'is_verified'         => false,
            'is_visible'          => false,
            'listing_status'      => Property::STATUS_PENDING,
            'subscription_expiry' => null,
        ];
    }

    /**
     * Approved, paid and on the public site - the only combination a
     * guest can actually see.
     */
    public function live(): static
    {
        return $this->state(fn () => [
            'listing_status'      => Property::STATUS_APPROVED,
            'is_visible'          => true,
            'subscription_expiry' => now()->addMonth()->toDateString(),
        ]);
    }

    /**
     * Approved and still flagged visible, but the paid window closed
     * yesterday - what properties:hide-expired is meant to catch.
     */
    public function expired(): static
    {
        return $this->live()->state(fn () => [
            'subscription_expiry' => now()->subDay()->toDateString(),
        ]);
    }
}
