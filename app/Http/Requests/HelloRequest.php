<?php

namespace App\Http\Requests;

use App\Rules\data;
use App\Rules\users;
use Illuminate\Foundation\Http\FormRequest;

class HelloRequest extends FormRequest
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
            'data'=>array('required','date', new data),
            'users_id'=>array('required', new users),
        ];

    }
    public function messages()
    {
        return[
            'data.required'=>'Nie wyznaczyłeś daty',
            'users_id.required'=>'Nie wyznaczyłeś recenzentów'
        ];
    }
}
