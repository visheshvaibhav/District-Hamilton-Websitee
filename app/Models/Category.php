<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_fr',
        'slug',
        'description_en',
        'description_fr',
        'is_deliverable',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'is_deliverable' => 'boolean',
        'is_visible' => 'boolean',
    ];

    /**
     * Get the menu items for this category.
     */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Get localized name based on current app locale.
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'fr' && $this->name_fr ? $this->name_fr : $this->name_en;
    }

    /**
     * Get localized description based on current app locale.
     */
    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'fr' && $this->description_fr ? $this->description_fr : $this->description_en;
    }

    public function getActiveMenuItems()
    {
        return $this->menuItems()->where('is_active', true)->where('is_available', true)->orderBy('sort_order')->get();
    }
}
