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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->enum('order_type', ['pickup', 'delivery'])->default('pickup');
            $table->text('delivery_address')->nullable();
            $table->integer('tip_percentage')->nullable();
            $table->decimal('tip_amount', 8, 2)->default(0);
            $table->decimal('delivery_fee', 8, 2)->default(0);
            $table->string('gift_card_code_used')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending'); // pending, preparing, ready, completed, canceled
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('payment_method')->default('card');
            $table->string('stripe_payment_id')->nullable();
            $table->timestamp('pickup_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
