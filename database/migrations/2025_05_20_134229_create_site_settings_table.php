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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_name')->default('The District Tapas + Bar');
            $table->string('restaurant_email')->default('contact@thedistricttapas.com');
            $table->string('restaurant_phone')->default('(555) 123-4567');
            $table->text('restaurant_address')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('hero_image_path')->nullable();
            $table->boolean('gift_card_system_enabled')->default(true);
            $table->string('primary_language')->default('en');
            $table->boolean('enable_french')->default(false);
            $table->text('alert_message')->nullable();
            $table->timestamps();
        });

        // Insert default record
        DB::table('site_settings')->insert([
            'id' => 1,
            'restaurant_name' => 'The District Tapas + Bar',
            'restaurant_email' => 'contact@thedistricttapas.com',
            'restaurant_phone' => '(555) 123-4567',
            'restaurant_address' => '',
            'gift_card_system_enabled' => true,
            'primary_language' => 'en',
            'enable_french' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
}; 