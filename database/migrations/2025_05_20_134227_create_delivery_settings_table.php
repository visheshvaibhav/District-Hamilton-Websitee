<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('delivery_radius_km')->default(5);
            $table->decimal('delivery_fee', 8, 2)->default(0);
            $table->time('kitchen_open_time')->default('16:00:00'); // 4pm
            $table->time('kitchen_close_time')->default('22:00:00'); // 10pm
            $table->integer('buffer_time_minutes')->default(15);
            $table->boolean('delivery_enabled')->default(true);
            $table->boolean('pickup_enabled')->default(true);
            $table->timestamps();
        });

        // Insert default record
        DB::table('delivery_settings')->insert([
            'id' => 1,
            'delivery_radius_km' => 5,
            'delivery_fee' => 3.99,
            'kitchen_open_time' => '16:00:00',
            'kitchen_close_time' => '22:00:00',
            'buffer_time_minutes' => 15,
            'delivery_enabled' => true,
            'pickup_enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_settings');
    }
}; 