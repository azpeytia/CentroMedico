<?php

namespace App\Http\Requests\Shifts;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePreviousShiftStatusRequest extends FormRequest
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
            'eventRecord' => ['required', 'integer', 'in:1,2,3'],
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
            'eventRecord.required' => 'El :attribute del turno es obligatorio',
            'eventRecord.integer' => 'El :attribute del turno debe ser un número entero',
            'eventRecord.in' => 'El :attribute del turno debe ser 1, 2 o 3',
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
            'eventRecord' => 'ID del turno',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'eventRecord' => (int) $this->input('eventRecord'),
        ]);
    }
}