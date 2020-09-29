<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSchoolRequest extends FormRequest
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
            'name' => 'required|string|min:10|max:150',
            'cue' => [
                'required',
                'digits:9',
                Rule::unique('schools', 'cue')->ignore($this->school->id)->where(function ($query) {
                    $query->where('level_id', $this->request->get('level_id'));
                })
            ],
            'address' => 'required|string|min:10|max:150',
            'phone' => 'nullable|digits_between:10,15',
            'internal_phone' => 'nullable|digits_between:10,15',
            'email' => [
                'required',
                'email', 'min:15',
                'max:100',
                Rule::unique('schools', 'email')->ignore($this->school->id)
            ],
            'number_students' => 'nullable|numeric|min:20|max:10000',
            'bilingual' => 'boolean',
            'director' => 'required|string|min:5|max:150',
            'orientation' => 'required|string|min:10|max:150',
            'ambit_id' => 'required|exists:school_ambits,id',
            'sector_id' => 'required|exists:school_sectors,id',
            'type_id' => 'required|exists:school_types,id',
            'level_id' => [
                'required', 'exists:school_levels,id',
                Rule::unique('schools', 'level_id')->ignore($this->school->id)->where(function ($query) {
                    $query->where('cue', $this->request->get('cue'));
                })
            ],            'category_id' => 'required|exists:school_categories,id',
            'journey_type_id' => 'required|exists:journey_types,id',
            'locality_id' => 'required|exists:localities,id',
            'high_school_type_id' => 'nullable|required_if:level_id,3|exists:high_school_types,id',
            'user_id' => [
                'nullable',
                'exists:users,id',
                Rule::unique('schools', 'user_id')->ignore($this->school->id)
            ]
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
            'user_id.unique' => 'El usuario ya tiene una escuela asignada.',
            'cue.unique' => 'El CUE y nivel ya se encuentran registrados.',
            'level_id.unique' => 'El CUE y nivel ya se encuentran registrados.',

        ];
    }
}
