<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TippingSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipping_enabled',
        'tip_percentages',
    ];

    protected $casts = [
        'tipping_enabled' => 'boolean',
        'tip_percentages' => 'array',
    ];

    /**
     * Get the default settings for tipping.
     */
    public static function getSettings()
    {
        return self::firstOrCreate(['id' => 1], [
            'tipping_enabled' => true,
            'tip_percentages' => [10, 15, 20],
        ]);
    }

    /**
     * Check if tipping is enabled.
     */
    public function isTippingEnabled(): bool
    {
        return $this->tipping_enabled;
    }

    /**
     * Get the available tip percentages.
     */
    public function getAvailableTipPercentages(): array
    {
        $percentages = $this->tip_percentages;
        
        // If the percentages are stored as array of objects (from Filament Repeater)
        if (is_array($percentages) && !empty($percentages) && isset($percentages[0]) && is_array($percentages[0]) && isset($percentages[0]['percentage'])) {
            return collect($percentages)->pluck('percentage')->toArray();
        }
        
        // Return as is if it's already a simple array of numbers
        return $percentages;
    }

    /**
     * Calculate tip amount based on subtotal and percentage.
     */
    public function calculateTipAmount(float $subtotal, int $percentage): float
    {
        if (!$this->isTippingEnabled()) {
            return 0;
        }
        
        // Validate the percentage is in the list of available percentages
        if (!in_array($percentage, $this->getAvailableTipPercentages())) {
            return 0;
        }
        
        return round(($subtotal * $percentage) / 100, 2);
    }
} 