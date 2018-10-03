<?php

namespace App\Http\Requests;

use App\Rules\OpiniaFile;
use Illuminate\Foundation\Http\FormRequest;

class OpiniaRequest extends FormRequest
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
            'confidence'=>'required',
            'decision'=>'required',
            'presentation'=>'required',
            'quality_of_formalization'=>'required',
            'significance_for_mml'=>'required',
            'comments'=>'required|min:10|max:1200',
            'comments_editors'=>'max:1200',
            'mml_remarks'=>'max:1200'
        ];
    }
    public function messages()
    {
        return [
            'confidence.required'=>'Pole wymagane. Uzupełnij!!',
            'decision.required'=>'Pole wymagane. Uzupełnij!!',
            'presentation.required'=>'Pole wymagane. Uzupełnij!!',
            'quality_of_formalization.required'=>'Pole wymagane. Uzupełnij!!',
            'significance_for_mml.required'=>'Pole wymagane. Uzupełnij!!',
            'comments.required'=>'Pole wymagane. Uzupełnij!!',
        ];
    }
}
