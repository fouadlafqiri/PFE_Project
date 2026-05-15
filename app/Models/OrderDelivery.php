<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \App\Models\Delivery|null $delivery
 * @property-read \App\Models\Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDelivery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDelivery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDelivery query()
 * @mixin \Eloquent
 */
class OrderDelivery extends Model
{
    use HasFactory;

    protected $table = 'order_deliveries';

    protected $fillable = [
        'order_id',
        'delivery_id',
        'status',
        'assigned_at',
        'picked_up_at',
        'delivered_at',
        'notes',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'idOrder');
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id', 'idDelivery');
    }
}
