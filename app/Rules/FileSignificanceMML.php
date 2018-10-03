<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileSignificanceMML implements Rule
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

        $poz_Significance_MML=strRpos($dane2, 'Significance for MML:');
        if($poz_Significance_MML==0)return false;

        $Significance_MML = substr(str_replace(' ', '', $dane[36]), 19, 1);
        if ($Significance_MML!='1'&&$Significance_MML!='2'&&$Significance_MML!='3'&&$Significance_MML!='0'){

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
        return 'Źle uzupełnione pole Significance for MML.';
    }
}
