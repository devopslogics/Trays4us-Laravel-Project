<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagSynonyms extends Model
{
    protected $table = 'tag_synonyms';

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}
