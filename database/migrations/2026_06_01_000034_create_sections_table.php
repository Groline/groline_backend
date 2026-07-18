<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ads', 'offer', 'family', 'group', 'ad', 'solo', 'band', 'categories', 'brands'])->nullable()->default(null);
            $table->string('element')->nullable()->default(null);
            $table->integer('rank')->nullable()->default(null);
            $table->tinyInteger('deleteable')->default(1);
            $table->tinyInteger('moveable')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
