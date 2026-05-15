<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDelivery> $orderDeliveries
 * @property-read int|null $order_deliveries_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Delivery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Delivery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Delivery query()
 * @mixin \Eloquent
 */
class Delivery extends Model
{
    use HasFactory;

    protected $table = 'deliveries';
    protected $primaryKey = 'idDelivery';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'vehicle_type',
        'vehicle_number',
        'status',
        'orders_completed',
        'rating',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
    ];

    // A delivery person can have many orders
    public function orderDeliveries()
    {
        return $this->hasMany(OrderDelivery::class, 'delivery_id', 'idDelivery');
    }
}
