<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class data implements Rule
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
    public function passes($attribute, $value)
    {
        $aktualna=strtotime(date("d.m.Y",strtotime("+7 days")));
        $wyznaczona=strtotime($value);
        if($aktualna<=$wyznaczona)return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Za krótki czas';
    }
}
