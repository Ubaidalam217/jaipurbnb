<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Splits capacity into adults / children / infants so the browse
 * "Guests" filter and the host form can tell them apart.
 *
 * max_guests (existing column) stays as the derived, queryable total:
 * max_adults + max_children. Infants never count toward it - that
 * derivation happens in Host\PropertyController, not here, so it stays
 * a plain integer column the existing browse filter can keep comparing
 * against without any query changes.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->integer('max_adults')->default(2);
            $table->integer('max_children')->default(0);
            $table->integer('max_infants')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['max_adults', 'max_children', 'max_infants']);
        });
    }
};
