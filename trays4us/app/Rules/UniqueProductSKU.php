<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueProductSKU implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the SKU is unique and not deleted
        return DB::table('products')
            ->where('product_sku', $value)
            ->where('status', '!=', '2')
            ->doesntExist();
    }

    public function message()
    {
        return 'The :attribute must be unique and not deleted.';
    }
}
