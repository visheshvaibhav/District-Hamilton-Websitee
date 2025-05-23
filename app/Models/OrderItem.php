<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_item_id',
        'name',
        'price',
        'quantity',
        'special_instructions',
        'options',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'options' => 'array',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the menu item that owns the order item.
     */
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }
    
    /**
     * Get the add-ons for this order item.
     */
    public function addOns(): BelongsToMany
    {
        return $this->belongsToMany(AddOn::class, 'order_item_add_ons')
            ->withPivot('price')
            ->withTimestamps();
    }

    /**
     * Calculate the subtotal for this order item.
     */
    public function calculateSubtotal()
    {
        $basePrice = $this->price * $this->quantity;
        
        // Calculate add-on prices from relationship
        $addonPrice = $this->addOns->sum('pivot.price') * $this->quantity;
        
        // If no pivot prices, use the add-on prices directly
        if ($addonPrice == 0 && $this->addOns->count() > 0) {
            $addonPrice = $this->addOns->sum('price') * $this->quantity;
        }
        
        // Calculate add-on prices from options array (legacy support)
        if ($addonPrice == 0 && !empty($this->options['add_ons'])) {
            foreach ($this->options['add_ons'] as $addon) {
                $addonPrice += $addon['price'] * $this->quantity;
            }
        }
        
        $this->subtotal = $basePrice + $addonPrice;
        
        return $this->subtotal;
    }
}
