<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZmienImieRequest extends FormRequest
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
            'imie'=>'required|min:6|max:255'
        ];
    }
    public function messages()
    {
        return [
            'imie.required'=>'Pole wymagane!!',
            'imie.min'=>'Za mało znaków minumum 6!!',
            'imie.max'=>'Za dużo znaków maksymalnie 255!!',
        ];
    }
}
