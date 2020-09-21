<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'phone' => 'required|digits_between:10,15',
            'dni' => ['required', 'digits:8', Rule::unique('users', 'dni')->ignore($this->user->id)],
        ];
    }
}
