<?php

namespace App\Http\Requests;

use App\Models\Locality;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrdenMeritoRequest extends FormRequest
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
            'incumbency' => ['nullable', 'regex:/(A1|A2|A3|B1|B2|B3|B4|B5|C1|C2|C3|C4|C5|NULL)/i'],
            'region' => 'required|integer|between:1,6',
            'level' => ['required', 'regex:/(inicial|primario|secundario)/i'],
            'last_name' => 'required|max:50',
            'name' => 'required|max:50',
            'cuil' => [
                'required', 'regex:/\b(20|23|24|27)(\D)-?[0-9]{8}-(\D)?[0-9]/',
                Rule::unique('orden_meritos', 'cuil')->where(function ($query) {
                    $query->where([
                        ['year', '=', $this->year],
                        ['charge', '=', $this->charge],
                    ]);
                })
            ],
            'gender' => 'required|in:FEMENINO,MASCULINO',
            'locality' => 'required|max:50',
            'charge' => 'required|max:100',
            'title1' => 'required|max:100',
            'title2' => 'nullable|max:100',
            'year' => 'required|integer|between:2000,2020'
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
            'incumbency.regex' => 'Valores permitidos: A1|A2|A3|B1|B2|B3|B4|B5|C1|C2|C3.',
            'level.regex' => 'Valores permitidos: Inicial|Primario|Secundario.',
            'cuil.regex' => 'Formato cuil invalido.',
            'cuil.unique' => 'El cuil ya se encuentra registrado con este cargo y año.',
        ];
    }
}
