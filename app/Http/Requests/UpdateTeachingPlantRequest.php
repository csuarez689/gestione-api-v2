<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeachingPlantRequest extends FormRequest
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
            'year' => 'required|integer|between:1,9',
            'division' => 'required|in:A,B,C,D,E',
            'subject' => [
                'required', 'string', 'min:5', 'max:100',
                Rule::unique('schools_teachers', 'subject')->ignore($this->teachingPlant->id)->where(function ($query) {
                    $query->where([
                        ['year', '=', $this->year],
                        ['division', '=', $this->division],
                        ['school_id', '=', $this->teachingPlant->school->id],
                    ]);
                })
            ],
            'monthly_hours' => 'required|numeric|between:10,200',
            'teacher_title' => 'nullable|required_with:teacher_id|string|min:10|max:150',
            'teacher_category_title' => 'nullable|required_with:teacher_id|in:DOCENTE,NO DOCENTE',
            'teacher_id' => 'nullable|exists:teachers,id',
            'job_state_id' => 'nullable|required_with:teacher_id|exists:job_states,id',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'division' => strtoupper($this->division),
            'teacher_category_title' => strtoupper($this->teacher_category_title),
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'subject.unique' => 'La materia ya se encuentra registrada para este curso.',
        ];
    }
}
