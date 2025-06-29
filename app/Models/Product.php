<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'purchase_price',
        'sell_price',
        'stock',
        'opening_stock',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
