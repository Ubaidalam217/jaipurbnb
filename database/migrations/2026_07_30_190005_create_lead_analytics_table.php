<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Append-only lead event log powering the host dashboard counters.
 *
 * lead_type (string, not ENUM):
 *   whatsapp_click | call_click | profile_view
 *
 * Deliberately has NO created_at/updated_at - clicked_at is the single
 * event timestamp, per the agreed schema.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->string('lead_type', 30);
            $table->timestamp('clicked_at')->useCurrent();

            $table->index(['property_id', 'lead_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_analytics');
    }
};
