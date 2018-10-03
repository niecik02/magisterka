<?php

namespace App\Http\Requests;

use App\Rules\users;
use Illuminate\Foundation\Http\FormRequest;

class RecenzentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'users_id'=>array('required', new users),
        ];

    }
    public function messages()
    {
        return[
            'users_id.required'=>'Nie wyznaczyłeś recenzentów'
        ];
    }
}
