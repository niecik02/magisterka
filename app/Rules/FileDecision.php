<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileDecision implements Rule
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

        $poz_decision=strRpos($dane2, 'The decision:');
        if($poz_decision==0)return false;
        $decision = substr(str_replace(' ', '', $dane[19]), 12, 1);

        if (ucfirst($decision)!='A'&&ucfirst($decision)!='B'&&ucfirst($decision)!='C'&&ucfirst($decision)!='D'&&ucfirst($decision)!='E'){
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
        return 'Źle uzupełnione pole The decision.';
    }
}
