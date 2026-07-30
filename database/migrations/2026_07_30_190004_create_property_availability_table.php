<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Per-date availability calendar.
 *
 * status  (string, not ENUM): available | blocked | booked
 * source  (string, not ENUM): manual | airbnb_sync
 *
 * The unique (property_id, calendar_date) constraint is what makes the
 * Milestone 3 iCal sync safe to re-run - it lets the importer upsert
 * one row per property per day instead of duplicating blocks.
 *
 * Table name is explicit and singular-ish ("property_availability"),
 * so the Eloquent model must declare $table = 'property_availability'.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->date('calendar_date');
            $table->string('status', 20);
            $table->string('source', 20)->default('manual');
            $table->timestamps();

            $table->unique(['property_id', 'calendar_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_availability');
    }
};
