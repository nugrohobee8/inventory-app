<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
    ];

    public function goodsReceipts()
    {
        return $this->hasMany(GoodsReceipt::class, 'suppliers_id');
    }
}
