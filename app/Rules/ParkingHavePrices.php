<?php

namespace App\Rules;

use App\Models\Parking;
use Illuminate\Contracts\Validation\Rule;

class ParkingHavePrices implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute,$value)
    {
        return Parking::where('id',$value)->first()->hasPrices();

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Selected parking does not have prices list.';
    }
}
