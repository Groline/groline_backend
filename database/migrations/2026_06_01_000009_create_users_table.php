<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('email')->nullable()->default(null)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable()->default(null);
            $table->rememberToken();
            $table->string('fcm_token')->nullable()->default(null);
            $table->integer('role')->default(1);
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('last_offers_visit')->nullable()->default(null);
            $table->timestamp('last_orders_visit')->nullable()->default(null);
            $table->timestamp('last_notifications_visit')->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
