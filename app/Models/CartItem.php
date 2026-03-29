<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';
    protected $primaryKey = 'idCartItem';

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // A cart item belongs to a cart
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'idCart');
    }

    // A cart item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'idProduct');
    }

    // Get subtotal for this item
    public function getSubtotal()
    {
        return $this->quantity * $this->product->priceProduct;
    }
}
