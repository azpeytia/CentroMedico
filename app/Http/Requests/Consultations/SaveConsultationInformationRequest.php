<?php

namespace App\Http\Requests\Consultations;

use Illuminate\Foundation\Http\FormRequest;

class SaveConsultationInformationRequest extends FormRequest
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
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'consultation_date' => ['required', 'date'],
            'reason_for_consultation' => ['required', 'string', 'max:255'],
            'allergies' => ['required', 'string', 'max:255'],
            'blood_pressure' => ['required', 'string', 'max:7'],
            'heart_rate' => ['required', 'string', 'max:3'],
            'respiratory_rate' => ['required', 'string', 'max:3'],
            'oxygen_saturation' => ['required', 'string', 'max:3'],
            'temperature' => ['required', 'string', 'max:3'],
            'weight' => ['required', 'string', 'max:3'],
            'height' => ['required', 'string', 'max:3'],
            'medications' => ['required', 'string'],
            'medical_conditions' => ['required', 'string'],
            'medical_history' => ['required', 'string'],
            'family_history' => ['required', 'string'],
            'diagnosis' => ['required', 'string'],
            'treatment' => ['required', 'string'],
            'follow_up_instructions' => ['required', 'string'],
            'notes' => ['required', 'string'],
            'is_active' => ['required', 'boolean'],
            'is_suspended' => ['required', 'boolean'],
            'is_deleted' => ['required', 'boolean'],
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
            'doctor_id.required' => 'El :attribute es requerido',
            'patient_id.required' => 'El :attribute es requerido',
            'consultation_date.required' => 'La :attribute es requerida',
            'reason_for_consultation.required' => 'El :attribute es requerido',
            'allergies.required' => 'Las :attribute son requeridas',
            'blood_pressure.required' => 'La :attribute es requerida',
            'heart_rate.required' => 'La :attribute es requerida',
            'respiratory_rate.required' => 'La :attribute es requerida',
            'oxygen_saturation.required' => 'La :attribute es requerida',
            'temperature.required' => 'La :attribute es requerida',
            'weight.required' => 'La :attribute es requerida',
            'height.required' => 'La :attribute es requerida',
            'medications.required' => 'Los :attribute son requeridos',
            'medical_conditions.required' => 'Las :attribute son requeridas',
            'medical_history.required' => 'El :attribute es requerido',
            'family_history.required' => 'El :attribute es requerido',
            'diagnosis.required' => 'El :attribute es requerido',
            'treatment.required' => 'El :attribute es requerido',
            'follow_up_instructions.required' => 'Las :attribute son requeridas',
            'notes.string' => 'Las :attribute deben ser una cadena de texto',
            'is_active.required' => 'El valor :attribute es requerido',
            'is_suspended.required' => 'El valor :attribute es requerido',
            'is_deleted.required' => 'El valor :attribute es requerido',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'doctor_id' => 'doctor',
            'patient_id' => 'paciente',
            'consultation_date' => 'fecha de consulta',
            'reason_for_consultation' => 'motivo de la consulta',
            'allergies' => 'alergias',
            'blood_pressure' => 'presión arterial',
            'heart_rate' => 'frecuencia cardíaca',
            'respiratory_rate' => 'frecuencia respiratoria',
            'oxygen_saturation' => 'saturación de oxígeno',
            'temperature' => 'temperatura',
            'weight' => 'peso',
            'height' => 'estatura',
            'medications' => 'medicamentos',
            'medical_conditions' => 'condiciones médicas',
            'medical_history' => 'historial médico',
            'family_history' => 'historial familiar',
            'diagnosis' => 'diagnóstico',
            'treatment' => 'tratamiento',
            'follow_up_instructions' => 'instrucciones de seguimiento',
            'notes' => 'notas',
            'is_active' => 'activo',
            'is_suspended' => 'suspendido',
            'is_deleted' => 'eliminado',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'doctor_id' => (int) $this->input('doctor_id'),
            'patient_id' => (int) $this->input('patient_id'),
            'consultation_date' => $this->input('consultation_date'),
            'reason_for_consultation' => $this->input('reason_for_consultation'),
            'allergies' => $this->input('allergies'),
            'blood_pressure' => $this->input('blood_pressure'),
            'heart_rate' => $this->input('heart_rate'),
            'respiratory_rate' => $this->input('respiratory_rate'),
            'oxygen_saturation' => $this->input('oxygen_saturation'),
            'temperature' => $this->input('temperature'),
            'weight' => $this->input('weight'),
            'height' => $this->input('height'),
            'medications' => $this->input('medications'),
            'medical_conditions' => $this->input('medical_conditions'),
            'medical_history' => $this->input('medical_history'),
            'family_history' => $this->input('family_history'),
            'diagnosis' => $this->input('diagnosis'),
            'treatment' => $this->input('treatment'),
            'follow_up_instructions' => $this->input('follow_up_instructions'),
            'notes' => $this->input('notes'),
            'is_active' => $this->input('is_active'),
            'is_suspended' => $this->input('is_suspended'),
            'is_deleted' => $this->input('is_deleted'),
        ]);
    }
}