<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'idProduct';

    protected $fillable = [
    'idCategory',
    'nameProduct',
    'descriptionProduct',
    'priceProduct',
    'quantityProduct',
    'imageProduct',
    'is_active',
    'is_featured',

];

    protected $casts = [
        'priceProduct' => 'decimal:2',
        'quantityProduct' => 'integer',
    ];

    // A product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class, 'idCategory', 'idCategory');
    }

    // A product can have many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'idProduct');
    }

    // A product can be in many orders
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'idProduct');
    }

    // A product can be in many carts
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id', 'idProduct');
    }

    // Check if product is in stock
    public function isInStock()
    {
        return $this->quantityProduct > 0;
    }

    // Check if product has enough stock
    public function hasStock($quantity)
    {
        return $this->quantityProduct >= $quantity;
    }
}
