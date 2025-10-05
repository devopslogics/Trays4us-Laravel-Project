<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickbooksToken extends Model
{
    protected $fillable = [
        'access_token', 'refresh_token', 'token_expiry'
    ];

    protected $dates = ['token_expiry'];
}
