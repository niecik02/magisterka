<?php

namespace App\Http\Requests;

use App\Rules\FileComments;
use App\Rules\FileCommentsDlugosc;
use App\Rules\FileConfiden;
use App\Rules\FileDecision;
use App\Rules\FileJustification;
use App\Rules\FileJustificationDlugosc;
use App\Rules\FileMMLDlugosc;
use App\Rules\FilePresentation;
use App\Rules\FileQuality;
use App\Rules\FileSignificanceMML;
use App\Rules\OpiniaFile;
use Illuminate\Foundation\Http\FormRequest;

class OpiniaFileRequest extends FormRequest
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
            'opinia'=>array('required','mimes:txt',new OpiniaFile(), new FileConfiden(),
                new FileDecision(), new FilePresentation(), new FileQuality(), new FileSignificanceMML(),
                new FileJustification(),new FileComments(), new FileJustificationDlugosc(),
                new FileCommentsDlugosc(),new FileMMLDlugosc()),
        ];
    }
    public function messages()
    {
        return [
            'opinia.required'=>'Brak pliku.',
            'opinia.mimes'=>'Złe rozszerzenie pliku.'
        ];
    }
}
