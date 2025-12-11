<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'sale_price',
        'image',
        'images',
        'sku',
        'stock_quantity',
        'is_active',
        'is_featured',
        'sort_order',
    ];
    //definir relation avec category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function ligne()
    {
        return $this->hasMany(CartItem::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'panier', 'livre_id', 'user_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }
    /**
     * Scope pour les produits actifs
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les produits en vedette
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }
    /**
     * Relation avec les items du panier
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Relation avec le panier
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
