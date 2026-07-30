<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Property photos - up to 15 per listing (limit enforced at the
 * FormRequest layer, not in the schema).
 *
 * image_url stores a path relative to the public disk, e.g.
 * "properties/17/abc123.jpg", served via /storage/properties/...
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->string('image_url', 255);
            $table->index('property_id');
            $table->boolean('is_cover')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_images');
    }
};
