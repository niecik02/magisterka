<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OpiniaFile implements Rule
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
        $dane = file($value);
        $dane2 = implode('', file($value));
        $poz_mml = strRpos($dane2, 'MML remarks');
        if($poz_mml==0) return false;
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Brak MML remarks.';
    }
}
