<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = 'tags';

    public function products()
    {
        return $this->belongsToMany(Product::class)->where('status', 1);
    }
    public function synonyms()
    {
        return $this->hasMany(TagSynonyms::class, 'tag_id', 'id');
    }
}
