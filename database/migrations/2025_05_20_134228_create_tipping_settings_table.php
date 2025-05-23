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
        Schema::create('tipping_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('tipping_enabled')->default(true);
            $table->json('tip_percentages')->default(json_encode([10, 15, 20]));
            $table->timestamps();
        });

        // Insert default record
        DB::table('tipping_settings')->insert([
            'id' => 1,
            'tipping_enabled' => true,
            'tip_percentages' => json_encode([10, 15, 20]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipping_settings');
    }
}; 