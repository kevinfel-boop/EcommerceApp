<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Relation avec le panier
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Relation avec le produit
     * C'EST CE QUI MANQUE !
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calcul du sous-total pour cet item
     */
    public function getSubtotalAttribute(): float
    {
        return (float) $this->price * $this->quantity;
    }

    /**
     * Formatage du prix
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2) . ' €';
    }

    /**
     * Formatage du sous-total
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return number_format($this->subtotal, 2) . ' €';
    }
}
