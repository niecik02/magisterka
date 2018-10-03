<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileMMLDlugosc implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        $dane2 = implode('', file($value));
        $poz_mml = strRpos($dane2, 'MML remarks');
        $mml_remarks= substr($dane2, $poz_mml);
        if (strlen($mml_remarks)>1200) return false;
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'MMM remarks może zawierać maksymalnie 1200 znaków.';
    }
}
