<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempProducts extends Model
{
    protected $table = 'temp_products';

    protected $fillable = [
        'product_name',
        'product_sku',
        'artist_id',
        'customer_id',
        'style_id',
        'product_customizable',
        'pt_parent_id',
        'pt_sub_id',
        'price',
        'country_id',
        'p_badge',
        'minimum_order_quantity',
        'user_logo',
        'case_pack',
        'type',
    ];

    public function images()
    {
        return $this->hasMany(TempProductImages::class, 'temp_product_id')->orderBy('sorting', 'asc');
    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(States::class, 'state_id');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id', 'id');
    }

    public function style()
    {
        return $this->belongsTo(ProductStyle::class, 'style_id');
    }

    public static function get_tags_list($tags_string)
    {
        if (isset($tags_string) and !empty(rtrim($tags_string, ','))) {
            $tags = explode(',', rtrim($tags_string, ','));
            $tags_str = '';
            foreach ($tags as $tag) {
                $existingTag = Tags::find($tag);
                if ($existingTag) {
                    $tags_str .= '<span class="tag"><span class="text" _value="'.$existingTag->id.'">'.$existingTag->tag_name.'</span><span class="close">×</span></span>';
                } else {
                    $tags_str .= '<span class="tag"><span class="text" _value="'.$tag.'">'.$tag.'</span><span class="close">×</span></span>';
                }
            }
            return $tags_str;
        }
    }

}
