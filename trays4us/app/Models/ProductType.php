<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_type';

    public function parentType()
    {
        return $this->belongsTo(ProductType::class, 'parent_id');
    }

    // Define a reverse relationship for child product types
    public function childTypes()
    {
        return $this->hasMany(ProductType::class, 'parent_id')->where("status", 1);
    }

    public function child_types_having_criteria()
    {
        return $this->hasMany(ProductType::class, 'parent_id')->where("status", 1)->whereNotNull('sku');
    }

    public function customizableTypeRelations()
    {
        return $this->hasMany(CustomizableTypeRelation::class, 'product_type_id');
    }

}
