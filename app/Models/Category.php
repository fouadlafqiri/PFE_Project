<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'idCategory';

    protected $fillable = [
        'nameCategory',
        'descriptionCategory',
        'imageCategory',
    ];

    // A category can have many products
    public function products()
    {
        return $this->hasMany(Product::class, 'idCategory', 'idCategory');
    }
}
