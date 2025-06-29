<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'product_id',
        'product_name',
        'quantity',
        'unit_price',
        'subtotal',
        'discount',
        'vat_rate',
        'vat_amount',
        'total',
        'paid_amount',
        'due_amount',
        'sale_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
