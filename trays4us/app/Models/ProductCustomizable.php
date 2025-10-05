<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCustomizable extends Model
{
    protected $table = 'product_customizable';

    public function customizableTypeRelations()
    {
        return $this->hasMany(CustomizableTypeRelation::class, 'product_customizable_id');
    }
}
