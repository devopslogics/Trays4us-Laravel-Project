<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizableTypeRelation extends Model
{
    protected $table = 'customizable_type_relation';

    public function productCustomizable()
    {
        return $this->belongsTo(ProductCustomizable::class, 'product_customizable_id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
