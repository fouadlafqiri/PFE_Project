<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idProduct
 * @property string $nameProduct
 * @property string|null $descriptionProduct
 * @property numeric $priceProduct
 * @property int $quantityProduct
 * @property int $idCategory
 * @property string|null $imageProduct
 * @property int $is_active
 * @property int $is_featured
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CartItem> $cartItems
 * @property-read int|null $cart_items_count
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescriptionProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIdCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIdProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImageProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereNameProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePriceProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereQuantityProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'idProduct';
    public $timestamps = false; // ← ADD THIS

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

    public function category()
    {
        return $this->belongsTo(Category::class, 'idCategory', 'idCategory');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'idProduct');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'idProduct');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id', 'idProduct');
    }

    public function isInStock()
    {
        return $this->quantityProduct > 0;
    }

    public function hasStock($quantity)
    {
        return $this->quantityProduct >= $quantity;
    }
}
