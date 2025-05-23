<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_radius_km',
        'delivery_fee',
        'kitchen_open_time',
        'kitchen_close_time',
        'buffer_time_minutes',
        'delivery_enabled',
        'pickup_enabled',
    ];

    protected $casts = [
        'delivery_fee' => 'decimal:2',
        'delivery_enabled' => 'boolean',
        'pickup_enabled' => 'boolean',
        'kitchen_open_time' => 'datetime:H:i',
        'kitchen_close_time' => 'datetime:H:i',
    ];

    /**
     * Get the default settings for delivery.
     */
    public static function getSettings()
    {
        return self::firstOrCreate(['id' => 1], [
            'delivery_radius_km' => 5,
            'delivery_fee' => 3.99,
            'kitchen_open_time' => '16:00:00',
            'kitchen_close_time' => '22:00:00',
            'buffer_time_minutes' => 15,
            'delivery_enabled' => true,
            'pickup_enabled' => true,
        ]);
    }

    /**
     * Check if the kitchen is currently open.
     */
    public function isKitchenOpen(): bool
    {
        $now = now();
        $openTime = \Carbon\Carbon::createFromFormat('H:i', $this->kitchen_open_time);
        $closeTime = \Carbon\Carbon::createFromFormat('H:i', $this->kitchen_close_time);
        
        return $now->between($openTime, $closeTime);
    }

    /**
     * Calculate the earliest possible pickup time.
     */
    public function calculateEarliestPickupTime(int $preparationTimeMinutes): \Carbon\Carbon
    {
        $now = now();
        $estimatedTime = $now->copy()->addMinutes($preparationTimeMinutes + $this->buffer_time_minutes);
        
        $openTime = \Carbon\Carbon::createFromFormat('H:i', $this->kitchen_open_time);
        $closeTime = \Carbon\Carbon::createFromFormat('H:i', $this->kitchen_close_time);
        
        if (!$this->isKitchenOpen()) {
            // If kitchen is closed, set to next available opening time
            if ($now->lt($openTime)) {
                // If current time is before opening, set to today's opening time
                return $openTime->copy()->addMinutes($preparationTimeMinutes + $this->buffer_time_minutes);
            } else {
                // If current time is after closing, set to tomorrow's opening time
                return $openTime->copy()->addDay()->addMinutes($preparationTimeMinutes + $this->buffer_time_minutes);
            }
        }
        
        // If estimated time exceeds closing time, return null or handle as needed
        if ($estimatedTime->gt($closeTime)) {
            return null;
        }
        
        return $estimatedTime;
    }
} 