<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddOn extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_item_id',
        'name_en',
        'name_fr',
        'price',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Get the menu item that owns the add-on.
     */
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    /**
     * Get localized name based on current app locale.
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'fr' && $this->name_fr ? $this->name_fr : $this->name_en;
    }
} 