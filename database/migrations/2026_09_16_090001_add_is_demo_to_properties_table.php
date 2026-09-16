<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Marks a listing as seeded demo content rather than a real host's property.
 *
 * The public site carries sample listings so /browse is not an empty state
 * during the client walkthrough, and those must be visually distinguishable
 * from real inventory - a guest should never WhatsApp the demo host about a
 * property that does not exist.
 *
 * Deliberately a real column rather than inferring "demo" from the seeder's
 * host email: the flag has to survive a host being renamed or re-pointed, and
 * an admin needs to be able to clear it on a listing that became real.
 *
 * No ->after() - it is a MySQL-only modifier and is silently ignored on the
 * SQLite used in local dev (see CLAUDE.md).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->boolean('is_demo')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('is_demo');
        });
    }
};
