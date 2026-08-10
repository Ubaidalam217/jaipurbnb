<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Founding Host promo: new hosts registering during the promo window get
 * their listings live free for 60 days, independent of subscription_expiry.
 * Null means the host never got the promo (registered before it existed,
 * or it has since been retired for new signups).
 *
 * No ->after(): per CLAUDE.md it is a MySQL-only modifier and is silently
 * ignored on SQLite, so column order is left to the database.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('founding_host_expires_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('founding_host_expires_at');
        });
    }
};
