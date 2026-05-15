<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $idCategory
 * @property string $nameCategory
 * @property string|null $descriptionCategory
 * @property string|null $imageCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescriptionCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIdCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereImageCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereNameCategory($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'idCategory';

    public $timestamps = false;

    protected $fillable = [
        'nameCategory',
        'descriptionCategory',
        'imageCategory',
        'slug',
    ];

    // A category can have many products
    public function products()
    {
        return $this->hasMany(Product::class, 'idCategory', 'idCategory');
    }
}
