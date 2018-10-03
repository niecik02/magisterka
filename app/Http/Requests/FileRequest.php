<?php

namespace App\Http\Requests;

use App\Rules\bib;
use App\Rules\voc;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\mizar;


class FileRequest extends FormRequest
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

        return[
            'title'=>'required',
            'plik_miz'=> array('required',new mizar),
            'plik_voc'=> array(new voc),
            'plik_bib'=>array('required',new bib),
        ];


        
        
    }
    public function messages()
    {

        return[
            'title.required'=>'Pole tytuł jest wymagane',
            'plik_miz.required'=>'Plik .miz jest wymagany',
            'plik_woc.required'=>'Plik .woc jest wymagany',
        ];
    }
}
