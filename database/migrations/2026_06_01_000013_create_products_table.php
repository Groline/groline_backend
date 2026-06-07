<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->nullable()->default(null)->constrained();
            $table->foreignId('subcategory_id')->constrained();
            $table->foreignId('brand_id')->nullable()->default(null)->constrained();
            $table->string('name_ar')->nullable()->default(null);
            $table->string('name_fr')->nullable()->default(null);
            $table->string('name_en')->nullable()->default(null);
            $table->double('unit_price')->default(0);
            $table->double('pack_price')->nullable()->default(null);
            $table->integer('pack_units')->nullable()->default(null);
            $table->integer('unit_type')->default(1);
            $table->enum('status', ['available', 'unavailable'])->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->double('in_stock')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
