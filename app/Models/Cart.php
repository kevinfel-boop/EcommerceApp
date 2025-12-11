<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantite',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the livre (book) that is in the cart.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
