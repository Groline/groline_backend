<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('longitude')->nullable()->default(null);
            $table->string('latitude')->nullable()->default(null);
            $table->json('boundaries');
            $table->timestamps();
            $table->softDeletes();
            $table->double('delivery_price')->default(250);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
