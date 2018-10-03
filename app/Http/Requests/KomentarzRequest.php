<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KomentarzRequest extends FormRequest
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
            'komentarz'=>'required|min:6|max:1000'
        ];
    }
    public function messages()
    {
        return [
            'komentarz.required'=>'Pole komentarz wymagane!!',
            'komentarz.min'=>'Za mało znaków minumum 6!!',
            'komentarz.max'=>'Za długi komenatrz',
        ];
    }
}
