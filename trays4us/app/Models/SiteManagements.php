<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteManagements extends Model
{
    protected $table = 'site_managements';


    protected $casts = [
        'display_order_value' => 'array',
    ];

    public static function getSiteManagment() {
        return SiteManagements::query()
            ->where('id', '=', 1)
            ->first();
    }
}
