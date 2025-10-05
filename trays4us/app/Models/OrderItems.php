<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = 'order_items';
    protected $fillable = ['quantity','sale_price'];
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class,'product_id', 'id');
    }

    public function productPrice()
    {
        return $this->belongsTo(ProductPrices::class,'product_prices_id', 'id');
    }
}
