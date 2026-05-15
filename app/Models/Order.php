<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDelivery> $orderDeliveries
 * @property-read int|null $order_deliveries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'idOrder';

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'shipping_address',
        'billing_address',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // An order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // An order has many items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'idOrder');
    }

    // An order has delivery records
    public function orderDeliveries()
    {
        return $this->hasMany(OrderDelivery::class, 'order_id', 'idOrder');
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}
