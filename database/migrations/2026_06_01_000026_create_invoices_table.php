<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('checkout_id')->nullable()->default(null);
            $table->foreignId('order_id')->constrained();
            $table->double('purchase_amount')->default(0);
            $table->double('tax_amount')->default(0);
            $table->double('discount_amount')->default(0);
            $table->double('total_amount')->default(0);
            $table->string('discount_code')->nullable()->default(null);
            $table->string('file')->nullable()->default(null);
            $table->enum('payment_method', ['cash', 'ccp', 'baridi', 'chargily'])->default('cash');
            $table->string('payment_account')->nullable()->default(null);
            $table->string('payment_receipt')->nullable()->default(null);
            $table->enum('is_paid', ['yes', 'no'])->default('no');
            $table->timestamp('paid_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
