<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CartItem> $cartItems
 * @property-read int|null $cart_items_count
 * @property-read \Illuminate\Foundation\Auth\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cart query()
 * @mixin \Eloquent
 */
class Cart extends Model
{
    use HasFactory;

    protected $table      = 'carts';
    protected $primaryKey = 'idCart';

    protected $fillable = [
        'user_id',
        'session_id',
    ];

    // ✅ Fixed: was \App\User::class (doesn't exist in Laravel 8+)
    public function user()
    {
        return $this->belongsTo(\Illuminate\Foundation\Auth\User::class, 'user_id', 'id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'idCart');
    }

    public function getTotal()
    {
        return $this->cartItems->sum(fn($item) => $item->quantity * $item->product->priceProduct);
    }

    public function getTotalItems()
    {
        return $this->cartItems->sum('quantity');
    }
}
