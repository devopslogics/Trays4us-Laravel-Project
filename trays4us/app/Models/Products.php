<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Products extends Model
{
   // use SoftDeletes;

    protected $table = 'products';

    public function prices()
    {
        return $this->hasMany(ProductPrices::class, 'product_id');
    }

    public function price_single()
    {
        return $this->hasOne(ProductPrices::class, 'product_id');
    }


    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id')->orderBy('sorting', 'asc');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id', 'id');
    }

    public function producttypeparent()
    {
        return $this->hasMany(ProductType::class,'pt_parent_id', 'product_id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'pt_parent_id');
    }

    public function style()
    {
        return $this->belongsTo(ProductStyle::class, 'style_id');
    }

    public function badge()
    {
        return $this->belongsTo(Badges::class, 'p_badge');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class);
    }

    public function tags2()
    {
        return $this->belongsToMany(Tags::class, 'products_tags', 'products_id', 'tags_id');
    }

    public function wishlist()
    {
        return $this->hasOne(Wishlist::class, 'product_id', 'id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'product_id', 'id');
    }

    public function productCustomizableRel()
    {
        return $this->belongsTo(ProductCustomizable::class, 'product_customizable', 'id');
    }

}
