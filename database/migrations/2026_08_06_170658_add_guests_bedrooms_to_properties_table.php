<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Capacity columns behind the guests and bedrooms browse filters.
 *
 * Defaults (2 guests / 1 bedroom / 1 bathroom) rather than nullable, so
 * every existing listing gets a sane value and the ">= n" filters never
 * have to reason about NULL. Hosts correct them from the edit form.
 *
 * No ->after(): per CLAUDE.md it is a MySQL-only modifier and is silently
 * ignored on SQLite, so column order is left to the database.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->integer('max_guests')->default(2);
            $table->integer('bedrooms')->default(1);
            $table->integer('bathrooms')->default(1);

            // Browse filters query these together, alongside the existing
            // neighborhood/stay_type index.
            $table->index(['max_guests', 'bedrooms']);
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex(['max_guests', 'bedrooms']);
            $table->dropColumn(['max_guests', 'bedrooms', 'bathrooms']);
        });
    }
};
