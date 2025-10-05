<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $table = 'states';

    public function getStateByCountryId($country_id)
    {
        $states = States::query()->select("*")->where('country_id', '=',  $country_id)->get();
        return $states;
    }
}
