<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItemTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_item_id',
        'tag_name',
        'tag_name_fr',
    ];

    /**
     * Get the menu item that owns the tag.
     */
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    /**
     * Get localized tag name based on current app locale.
     */
    public function getTagNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'fr' && $this->tag_name_fr ? $this->tag_name_fr : $this->tag_name;
    }
} 