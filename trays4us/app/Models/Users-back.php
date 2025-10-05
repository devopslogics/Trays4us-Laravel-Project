<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
	
	/*
    public function user_restaurant()
    {
        return $this->hasMany(UserRestaurant::class, 'user_id', 'id');
    }

    public function detail()
    {
        return $this->hasOne(UsersDetails::class, 'user_id');
    } */
}
