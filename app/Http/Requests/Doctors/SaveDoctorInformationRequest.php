<?php

namespace App\Http\Requests\Doctors;

use Illuminate\Foundation\Http\FormRequest;

class SaveDoctorInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_name' => 'required|string|max:255',
            'doctor_license_number' => 'required|string|max:255',
            'doctor_specialty' => 'required|string|max:255',
            'doctor_email' => 'required|email|max:255',
            'doctor_phone' => 'required|string|max:20',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'doctor_name.required' => 'El :attribute del doctor es obligatorio.',
            'doctor_license_number.required' => 'El :attribute del doctor es obligatorio.',
            'doctor_specialty.required' => 'La :attribute del doctor es obligatoria.',
            'doctor_email.required' => 'El :attribute del doctor es obligatorio.',
            'doctor_phone.required' => 'El :attribute del doctor es obligatorio.',
        ];
    }

    /**
     * Get the custom attributes for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'doctor_name' => 'nombre',
            'doctor_license_number' => 'licencia profesional',
            'doctor_specialty' => 'especialidad',
            'doctor_email' => 'correo electrónico',
            'doctor_phone' => 'teléfono',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation(): array
    {
        return [
            'doctor_name' => $this->input('doctor_name'),
            'doctor_license_number' => $this->input('doctor_license_number'),
            'doctor_specialty' => $this->input('doctor_specialty'),
            'doctor_email' => $this->input('doctor_email'),
            'doctor_phone' => $this->input('doctor_phone'),
        ];
    }
}