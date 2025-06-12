<?php

namespace App\Http\Requests\Shifts;

use Illuminate\Foundation\Http\FormRequest;

class GetCurrentShiftStatusRequest extends FormRequest
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
            'eventRecord.shiftId' => ['required', 'integer'],
            'eventRecord.shiftDate' => ['required', 'date_format:Y-m-d'],
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
            'eventRecord.shiftId.required' => 'El :attribute es obligatorio',
            'eventRecord.shiftId.integer' => 'El :attribute debe ser un número entero',
            'eventRecord.shiftDate.required' => 'La :attribute es obligatoria',
            'eventRecord.shiftDate.date_format' => 'La :attribute debe tener el formato YYYY-MM-DD',
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
            'eventRecord.shiftId' => 'ID del turno',
            'eventRecord.shiftDate' => 'fecha del turno',
        ];
    }
}