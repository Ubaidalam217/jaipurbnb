<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->boolean('is_pet_friendly')->default(false);

            // The browse filter checkbox queries this directly.
            $table->index('is_pet_friendly');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex(['is_pet_friendly']);
            $table->dropColumn('is_pet_friendly');
        });
    }
};
