<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Stores why an admin rejected a listing, so the host can see it on
 * their dashboard and fix the listing before resubmitting.
 *
 * Kept as a separate nullable text column rather than reusing
 * verification_doc_url - those are unrelated concerns and overloading
 * one column would break as soon as both are needed at once.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('rejection_reason');
        });
    }
};
