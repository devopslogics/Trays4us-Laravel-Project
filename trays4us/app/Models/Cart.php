<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = [
        'customer_id',
        'product_id', // Add this line
        'product_prices_id',
        'quantity',
        // ... other fields
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    // Define the relationship with the ProductPrice model
    public function productPrice()
    {
        return $this->belongsTo(ProductPrices::class, 'product_prices_id');
    }
}
