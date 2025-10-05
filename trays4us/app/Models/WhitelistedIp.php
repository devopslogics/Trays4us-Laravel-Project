<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhitelistedIp extends Model
{
    // Add admin_id and ip_address to fillable to allow mass assignment
    protected $fillable = ['admin_id', 'ip_address'];

    // Define the relationship between the IP and the admin (User)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

