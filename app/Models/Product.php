<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'category_id',
        'unit',
        'min_stock',
        'description',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
