<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artist';

    public function products() {
        return $this->hasMany(Products::class, 'artist_id')->where('status', 1);
    }

    public function limited_products() {
        return $this->hasMany(Products::class, 'artist_id')->where('status', 1)->take(10);
    }

}
