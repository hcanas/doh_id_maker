<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CreateEmployee extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'photo' => ['nullable', 'file'],
            'code' => ['required', 'unique:employees'],
            'given_name' => ['required', Rule::unique('employees')
                ->where('family_name', $this->input('family_name'))
            ],
            'middle_name' => ['nullable'],
            'family_name' => ['required'],
            'name_suffix' => ['nullable'],
            'nickname' => ['nullable'],
            'address' => ['required'],
            'contact_number' => ['required'],
            'email' => ['nullable'],
            'position' => ['required'],
            'birth_date' => ['required', 'date'],
            'sex' => ['required', Rule::in(['Male', 'Female'])],
            'blood_type' => ['nullable'],
            'gsis_number' => ['nullable'],
            'pagibig_number' => ['nullable'],
            'philhealth_number' => ['nullable'],
            'tin_number' => ['nullable'],
            'emergency_contact' => ['nullable'],
            'emergency_contact_number' => ['nullable'],
            'active_from' => ['nullable', 'date'],
            'active_to' => ['nullable', 'date'],
        ];
    }
    
    /**
     * Add custom error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'given_name.unique' => 'Employee already exists in the database.',
        ];
    }
}
