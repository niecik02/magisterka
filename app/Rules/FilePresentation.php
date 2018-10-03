<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FilePresentation implements Rule
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

        $poz_presentation=strRpos($dane2, 'Presentation:');
        if($poz_presentation==0)return false;
        $presentation = substr(str_replace(' ', '', $dane[30]), 13, 1);
        if ($presentation!='1'&&$presentation!='2'&&$presentation!='3'&&$presentation!='0'){
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
        return 'Źle uzupełnione pole Presentation.';
    }
}
