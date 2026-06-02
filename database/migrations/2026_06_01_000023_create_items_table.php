<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->string('name_ar')->nullable()->default(null);
            $table->string('name_en')->nullable()->default(null);
            $table->string('name_fr')->nullable()->default(null);
            $table->double('unit_price')->default(0);
            $table->double('pack_price')->nullable()->default(null);
            $table->integer('pack_units')->nullable()->default(null);
            $table->enum('type', ['unit', 'pack'])->nullable()->default(null);
            $table->integer('quantity')->default(0);
            $table->double('discount')->default(0);
            $table->double('amount')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
