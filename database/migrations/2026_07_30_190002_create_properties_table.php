<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Core listing table.
 *
 * listing_status and is_visible are two INDEPENDENT axes:
 *   listing_status = admin moderation (pending | approved | rejected)
 *   is_visible     = live-on-site flag, set false by the daily expiry
 *                    cron once subscription_expiry has passed.
 * An expired listing stays 'approved' but becomes is_visible = false.
 * Listing data is never deleted.
 *
 * listing_status is a string (not ENUM) for SQLite/MySQL portability.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained('users')->cascadeOnDelete();
            $table->string('title', 150);
            $table->text('description');
            $table->string('neighborhood', 100);
            $table->string('stay_type', 50);
            $table->integer('approx_price');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_visible')->default(false);
            $table->string('listing_status', 20)->default('pending');
            $table->date('subscription_expiry')->nullable();
            $table->string('verification_doc_url', 255)->nullable();
            $table->string('ical_feed_url', 255)->nullable();
            $table->timestamps();

            $table->index(['neighborhood', 'stay_type']);
            $table->index('is_visible');
            $table->index('subscription_expiry');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
