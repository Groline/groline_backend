<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Delete all locations records that have NULL region_id
        \App\Models\Location::whereNull('region_id')->delete();

        Schema::table('locations', function (Blueprint $table) {
            $table->foreignId('region_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->foreignId('region_id')->nullable()->default(null)->change();
        });
    }
};
