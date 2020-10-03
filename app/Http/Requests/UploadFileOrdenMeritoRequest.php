<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileOrdenMeritoRequest extends FormRequest
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
            'file' => 'required|mimes:xls,xlsx,csv,txt|file|max:10000',
            'year' => 'required|integer|between:2000,2030'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file.file' => 'Debe incluir un archivo.',
            'file.mimes' => 'Formato invalido. (xls, xlsx, csv).',
            'file.max' => 'El archivo no debe superar los 10mb.',
        ];
    }
}
