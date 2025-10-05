<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = 'countries';

    public static function getCountries()
    {
        $countries = Countries::query()->select("*")->whereIn('status', [1])->get();
        return $countries;
    }

}
