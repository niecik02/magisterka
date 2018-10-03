<?php

namespace App\Http\Requests;

use App\Rules\bib;
use App\Rules\mizar;
use App\Rules\voc;
use Illuminate\Foundation\Http\FormRequest;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateFileRequest extends FormRequest
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
            'plik_miz'=> array('required',new mizar),
            'plik_voc'=> array(new voc),
            'plik_bib'=>array('required',new bib),
        ];
    }
    public function messages()
    {
        return[
            'plik_mml.required'=>'Nie dodałeś pliku',
            'plik_miz.required'=>'Nie dodałeś pliku'
        ];
    }
}
