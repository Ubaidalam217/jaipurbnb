<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Master amenity list, seeded once by AmenitySeeder from the client's
 * category groupings (basics | popular | features | location).
 *
 * category is a plain string column (no DB-level ENUM), matching every
 * other fixed-value-set column in this schema - see Amenity::CATEGORIES.
 *
 * No updated_at: the seeder is the only writer and always upserts by
 * name, so there is nothing an update timestamp would ever tell you.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('category', 20);
            $table->string('icon', 100)->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('amenities');
    }
};
