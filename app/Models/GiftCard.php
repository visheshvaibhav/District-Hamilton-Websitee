<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'amount',
        'recipient_name',
        'recipient_email',
        'sender_name',
        'sender_email',
        'message',
        'delivery_type',
        'is_redeemed',
        'redeemed_at',
        'order_id',
        'stripe_payment_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_redeemed' => 'boolean',
        'redeemed_at' => 'datetime',
    ];

    /**
     * Get the order that redeemed this gift card.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Generate a unique gift card code.
     */
    public static function generateCode(): string
    {
        do {
            $code = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 12));
            $exists = self::where('code', $code)->exists();
        } while ($exists);

        return $code;
    }

    /**
     * Check if the gift card is valid for use.
     */
    public function isValid(): bool
    {
        return !$this->is_redeemed;
    }

    /**
     * Mark the gift card as redeemed.
     */
    public function redeem(int $orderId = null): void
    {
        $this->is_redeemed = true;
        $this->redeemed_at = now();
        
        if ($orderId) {
            $this->order_id = $orderId;
        }
        
        $this->save();
    }

    /**
     * Validate a gift card code.
     */
    public static function validateCode(string $code): array
    {
        $giftCard = self::where('code', $code)->first();
        
        if (!$giftCard) {
            return [
                'valid' => false,
                'message' => 'Gift card not found',
            ];
        }
        
        if ($giftCard->is_redeemed) {
            return [
                'valid' => false,
                'message' => 'Gift card has already been redeemed',
                'redeemed_at' => $giftCard->redeemed_at->format('M d, Y'),
            ];
        }
        
        return [
            'valid' => true,
            'amount' => $giftCard->amount,
            'code' => $giftCard->code,
        ];
    }
} 