<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Host's own postal address, separate from any property address. All
 * nullable: existing hosts have none on file and registration does not
 * require them.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('host_address')->nullable();
            $table->string('host_city', 100)->nullable();
            $table->string('host_state', 100)->nullable();
            $table->string('host_pincode', 10)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['host_address', 'host_city', 'host_state', 'host_pincode']);
        });
    }
};
