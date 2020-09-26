<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:100',
            'last_name' => 'required|string|min:3|max:100',
            'cuil' => ['required', 'regex:/\b(20|23|24|27)(\D)-?[0-9]{8}-(\D)?[0-9]/', Rule::unique('teachers', 'cuil')->ignore($this->teacher->id)],
            'gender' => 'required|in:Masculino,Femenino',
            'locality_id' => 'required|exists:localities,id',
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
            'cuil.unique' => 'El CUIT/CUIL ya se encuentra registrado.',
            'cuil.regex' => 'Formato invalido. (XX-DNI-X)',
        ];
    }
}
