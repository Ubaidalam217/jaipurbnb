<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->text('full_address')->nullable();
            $table->string('city', 100)->default('Jaipur');
            $table->string('state', 100)->default('Rajasthan');
            $table->string('pincode', 10)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['full_address', 'city', 'state', 'pincode']);
        });
    }
};
