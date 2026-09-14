<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pivot for Property <-> Amenity. Named explicitly (not the alphabetical
 * "amenity_property" Eloquent would default to) so both
 * Property::amenities() and Amenity::properties() have to pass it
 * as the second belongsToMany() argument - see those models.
 *
 * unique(property_id, amenity_id) makes the host form's amenity sync
 * idempotent: re-submitting the same checkbox set can never duplicate a
 * row.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_amenities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->foreignId('amenity_id')->constrained('amenities')->cascadeOnDelete();

            $table->unique(['property_id', 'amenity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_amenities');
    }
};
