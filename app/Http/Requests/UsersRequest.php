<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UsersRequest extends FormRequest
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
            'name' => 'required|string|max:50|min:6',
            'email' => 'required|string|email|max:255|unique:users',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Brak imienia i nazwiska!!',
            'name.max'=>'Pole może zawierać maksymalnie 50 znaków!!',
            'email.max'=>'Pole może zawierać maksymalnie 255 znaków!!',
            'name.min'=>'Za krótkie imie i nazwisko!!',
            'email.required'=>'Brak emaila!!',
            'email.unique'=>'Użytkownik istnieje!!',
            'email.email'=>'Niepoprawny adres email!!',
        ];
    }
}
