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
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('recipient_name');
            $table->string('recipient_email')->nullable();
            $table->string('sender_name');
            $table->string('sender_email');
            $table->text('message')->nullable();
            $table->enum('delivery_type', ['ecard', 'physical'])->default('ecard');
            $table->boolean('is_redeemed')->default(false);
            $table->timestamp('redeemed_at')->nullable();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('stripe_payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_cards');
    }
}; 