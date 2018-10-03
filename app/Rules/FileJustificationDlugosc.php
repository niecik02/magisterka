<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileJustificationDlugosc implements Rule
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
        $poz_comments = strRpos($dane2, 'Comments to editors only') + 24;
        $comments= trim(substr($dane2, $poz_justification, $poz_comments - $poz_justification - 57));
        if (strlen($comments)<10||strlen($comments)>1200) return false;
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Justification/comments może zawierać od 10 do 1200 znaków.';
    }
}
