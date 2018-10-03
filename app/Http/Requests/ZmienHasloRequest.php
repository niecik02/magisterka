<?php

namespace App\Http\Requests;

use App\Rules\SprawdzHaslo;
use Illuminate\Foundation\Http\FormRequest;

class ZmienHasloRequest extends FormRequest
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
            'stare'=>array('required',new SprawdzHaslo()),
            'nowe'=>'required|string|min:6|confirmed',
            'nowe_confirmation'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'stare.required'=>'Pole wymagane!!',
            'nowe.required'=>'Pole wymagane!!',
            'nowe.min'=>'Za krótkie hasło!!',
            'nowe.confirmed'=>'Hasła różnią się!!',
            'nowe.string'=>'Hasło zawiera złe znaki!!',
            'nowe_confirmation.required'=>'Pole wymagane!!',

        ];
    }
}
