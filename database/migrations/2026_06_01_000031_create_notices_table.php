<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->string('title_fr')->nullable()->default(null);
            $table->string('content_ar');
            $table->string('content_en');
            $table->text('content_fr')->nullable()->default(null);
            $table->smallInteger('type');
            $table->smallInteger('priority')->default(0);
            $table->json('metadata')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
