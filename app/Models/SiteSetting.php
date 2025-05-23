<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_name',
        'restaurant_email',
        'restaurant_phone',
        'restaurant_address',
        'logo_path',
        'hero_image_path',
        'about_image_path',
        'story_image_path',
        'gift_card_system_enabled',
        'primary_language',
        'enable_french',
        'alert_message',
        'mailgun_api_key',
        'stripe_api_key',
        'admin_email',
    ];

    protected $casts = [
        'gift_card_system_enabled' => 'boolean',
        'enable_french' => 'boolean',
    ];

    /**
     * Get the default settings for the site.
     */
    public static function getSettings()
    {
        return self::firstOrCreate(['id' => 1], [
            'restaurant_name' => 'The District Tapas + Bar - Hamilton',
            'restaurant_email' => 'thedistricthamilton@gmail.com',
            'restaurant_phone' => '(905) 522-2580',
            'restaurant_address' => '61 Barton St E, Hamilton, ON L8L 2V7',
            'gift_card_system_enabled' => false,
            'primary_language' => 'en',
            'enable_french' => false,
            'admin_email' => 'thedistricthamilton@gmail.com',
        ]);
    }

    /**
     * Check if gift card system is enabled.
     */
    public function isGiftCardSystemEnabled(): bool
    {
        return $this->gift_card_system_enabled;
    }

    /**
     * Check if French language is enabled.
     */
    public function isFrenchEnabled(): bool
    {
        return $this->enable_french;
    }

    /**
     * Get the supported languages.
     */
    public function getSupportedLanguages(): array
    {
        $languages = ['en' => 'English'];
        
        if ($this->isFrenchEnabled()) {
            $languages['fr'] = 'Français';
        }
        
        return $languages;
    }
    
    /**
     * Get admin email address
     */
    public function getAdminEmail(): string
    {
        return $this->admin_email ?: $this->restaurant_email;
    }
} 