<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileConfiden implements Rule
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
        $poz_confiden=strRpos($dane2, 'Confidence:');
        if($poz_confiden==0)return false;
        if(!isset($dane[14])) return false;
        $confiden= substr(str_replace(' ', '', $dane[14]), 11, 1);
        if (ucfirst($confiden)!='A'&&ucfirst($confiden)!='B'&&ucfirst($confiden)!='C'){
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
        return 'Źle uzupełnione pole Confidence.';
    }
}
