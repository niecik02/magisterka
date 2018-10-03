<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileQuality implements Rule
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

        $poz_quality=strRpos($dane2, 'The quality of formalization:');

        if($poz_quality==0)return false;

        $quality = substr(str_replace(' ', '', $dane[33]), 26, 1);
        if ($quality!='1'&&$quality!='2'&&$quality!='3'&&$quality!='0'){
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Źle uzupełnione pole The quality of formalization.';
    }
}
