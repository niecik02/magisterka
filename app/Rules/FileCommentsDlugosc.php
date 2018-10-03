<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileCommentsDlugosc implements Rule
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


        $poz_comments = strRpos($dane2, 'Comments to editors only');
        $poz_mml = strRpos($dane2, 'MML remarks');
        $comments_editors= trim(substr($dane2, $poz_comments, $poz_mml - $poz_comments - 44));
        if (strlen($comments_editors)>1200) return false;
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Comments to editors only może zawierać maksymalnie 1200 znaków.';
    }
}
