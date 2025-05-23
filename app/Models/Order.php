<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'order_type',
        'delivery_address',
        'tip_percentage',
        'tip_amount',
        'delivery_fee',
        'gift_card_code_used',
        'subtotal',
        'tax',
        'total',
        'status',
        'payment_status',
        'payment_method',
        'stripe_payment_id',
        'pickup_time',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'tip_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'pickup_time' => 'datetime',
    ];

    /**
     * Get the order items for this order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Check if the order is a delivery order.
     */
    public function isDelivery(): bool
    {
        return $this->order_type === 'delivery';
    }

    /**
     * Check if the order is a pickup order.
     */
    public function isPickup(): bool
    {
        return $this->order_type === 'pickup';
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-' . strtoupper(substr(uniqid(), -6));
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Calculate and update order totals including items, tax, tip and delivery fee.
     */
    public function calculateTotals(): void
    {
        // Calculate subtotal from all order items
        $subtotal = $this->items->sum('subtotal');
        
        // Calculate tax (13%)
        $tax = round($subtotal * 0.13, 2);
        
        // Set up initial total
        $total = $subtotal + $tax;
        
        // Add delivery fee if this is a delivery order
        if ($this->isDelivery()) {
            // Use the configured delivery fee or the existing one
            $deliveryFee = $this->delivery_fee ?? DeliverySetting::getSettings()->delivery_fee;
            $this->delivery_fee = $deliveryFee;
            $total += $deliveryFee;
            
            // Calculate tip if a percentage is set and tipping is enabled
            if ($this->tip_percentage) {
                $tippingSettings = TippingSetting::getSettings();
                
                if ($tippingSettings->isTippingEnabled()) {
                    $tipAmount = $tippingSettings->calculateTipAmount($subtotal, $this->tip_percentage);
                    $this->tip_amount = $tipAmount;
                    $total += $tipAmount;
                }
            }
        }
        
        // Subtract gift card amount if one was used
        if ($this->gift_card_code_used) {
            $giftCard = GiftCard::where('code', $this->gift_card_code_used)
                ->where('is_redeemed', false)
                ->first();
                
            if ($giftCard) {
                $total = max(0, $total - $giftCard->amount);
                
                // If the order gets completed, we'll need to mark the gift card as redeemed
                // This will happen in the checkout controller, not here
            }
        }
        
        // Update the order totals
        $this->subtotal = $subtotal;
        $this->tax = $tax;
        $this->total = $total;
    }
}
