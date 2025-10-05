<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrices extends Model
{
    protected $table = 'product_prices';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
