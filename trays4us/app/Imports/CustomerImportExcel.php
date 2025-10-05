<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\States;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Psr\Log\NullLogger;

class CustomerImportExcel implements WithHeadingRow, ToCollection
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    use Importable;

    public $insertedCount = 0;

    public function collection(Collection $rows)
    {
        $rows = $rows->slice(1);
        //[0] => Company Name
        //[1] => Email
       // [2] => Buyer's name
       // [3] => Shipping Address
       // [4] => Address 2
       // [5] => City
       // [6] => State
       // [7] => ZIP

        foreach ($rows as $row) {
            if (!empty($row[0]) && !empty($row[1])) {

                if (isset($row[6]) && !empty($row[6])) {
                    $abbrev = strtoupper($row[6]);
                    $state = States::where('country_id', 231)
                        ->whereRaw("UPPER(`abbrev`) = ?", [$abbrev])
                        ->first();
                }
                $customer = Customer::query()
                    ->where('email', '=',  $row[1])
                    ->first();
                if(!$customer) {
                    $customer = new Customer();
                    $customer->first_name = $row[2] ?? $row[0];
                    $customer->last_name = NULL;
                    $customer->company = $row[0];
                    $customer->email = $row[1];
                    $randomPassword = Str::random(10);
                    $customer->password = Hash::make($randomPassword);
                    $customer->phone = NULL;
                    $customer->shiping_address1 = $row[3] ?? NULL;
                    $customer->shiping_address2 = $row[4] ?? NULL;
                    $customer->postal_code = $row[0] ?? NULL;
                    $customer->country_id = 231;
                    $customer->state_id = $state->id ?? NULL;
                    $customer->city = $row[0] ?? NULL;
                    $customer->is_verified = 1;
                    $customer->type = 3;
                    $customer->website =NULL;
                    $customer->save();
                    $this->insertedCount++;
                }
            }
        }

    }

    public function getInsertedCount()
    {
        return $this->insertedCount;
    }
}
