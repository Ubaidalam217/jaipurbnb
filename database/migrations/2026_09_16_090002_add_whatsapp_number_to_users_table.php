<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Optional separate WhatsApp number for a host.
 *
 * Until now a single users.phone_number drove both the tel: and the wa.me
 * link. That is wrong for the common case where a host answers calls on one
 * number and WhatsApp on another (a landline or an office line for calls, a
 * personal mobile for chat). When this is null the WhatsApp link falls back
 * to phone_number, so existing hosts keep working untouched.
 *
 * NOT unique, unlike phone_number: two hosts in a family business legitimately
 * share one WhatsApp line, and a unique index here would block the second
 * signup with a confusing error. phone_number stays unique because it is the
 * de-facto account identifier.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('whatsapp_number', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('whatsapp_number');
        });
    }
};
