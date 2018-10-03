<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileJustification implements Rule
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
        $dane2 = implode('', file($value));

        $poz_justification = strRpos($dane2, 'Justification/comments (to be forwarded to the authors)') + 55;
        if($poz_justification==0)return false;
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Brak Justification/comments.';
    }
}
