<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('versions', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ['android', 'ios']);
            $table->string('version_number')->nullable()->default(null);
            $table->string('build_number')->nullable()->default(null);
            $table->smallInteger('priority')->nullable()->default(null);
            $table->string('link')->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('versions');
    }
};
