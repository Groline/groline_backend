<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->default(1)->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('cart_id')->constrained();
            $table->string('phone');
            $table->timestamp('delivery_time')->useCurrent();
            $table->string('longitude');
            $table->string('latitude');
            $table->enum('status', ['pending', 'accepted', 'canceled', 'ongoing', 'delivered', 'chargily'])->default('pending');
            $table->longText('note')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->enum('delivery_time_slot', ['07:00 - 12:00', '13:00 - 16:00', '16:00 - 19:00'])->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
