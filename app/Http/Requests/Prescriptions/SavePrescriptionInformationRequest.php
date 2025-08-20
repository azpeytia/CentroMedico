<?php

namespace App\Http\Requests\Prescriptions;

use Illuminate\Foundation\Http\FormRequest;

class SavePrescriptionInformationRequest extends FormRequest
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
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'consultation_id' => 'required|exists:consultations,id',
            'notes' => 'required|string|max:1000',
            'prescription_date' => 'required|date',
        ];
    }

    /**
     * Get the validation messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'doctor_id.required' => 'El campo :attribute es obligatorio.',
            'patient_id.required' => 'El campo :attribute es obligatorio.',
            'consultation_id.required' => 'El campo :attribute es obligatorio.',
            'notes.required' => 'El campo :attribute es obligatorio.',
            'prescription_date.required' => 'El campo :attribute es obligatorio.',
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
            'doctor_id' => 'doctor',
            'patient_id' => 'paciente',
            'consultation_id' => 'consulta',
            'notes' => 'notas médicas',
            'prescription_date' => 'fecha de receta',
        ];
    }

    /**
     * Get the custom attributes for validation errors.
     *
     * @return array<string, string>
     */
    public function prepareForValidation(): array
    {
        return [
            'doctor_id' => $this->input('doctor_id'),
            'patient_id' => $this->input('patient_id'),
            'consultation_id' => $this->input('consultation_id'),
            'notes' => $this->input('notes'),
            'prescription_date' => $this->input('prescription_date'),
        ];
    }
}