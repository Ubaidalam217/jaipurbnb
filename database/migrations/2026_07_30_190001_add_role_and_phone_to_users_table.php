<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds JaipurBnB host/admin fields to Laravel's default users table.
 *
 * role is a string (not ENUM) for SQLite/MySQL portability. Allowed
 * values: host | admin. Enforced at the model + FormRequest layer.
 *
 * No ->after() is used - that modifier is MySQL-only and is silently
 * ignored on SQLite.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('host');
            $table->string('phone_number', 20)->nullable()->unique();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['phone_number']);
            $table->dropColumn(['role', 'phone_number']);
        });
    }
};
