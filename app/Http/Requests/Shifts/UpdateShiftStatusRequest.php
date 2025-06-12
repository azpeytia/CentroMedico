<?php

namespace App\Http\Requests\Shifts;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShiftStatusRequest extends FormRequest
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
            'eventRecord.isStarted' => ['required', 'boolean'],
            'eventRecord.isFinished' => ['required', 'boolean'],
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
            'eventRecord.shiftId.required' => 'El ID es obligatorio',
            'eventRecord.shiftId.integer' => 'El ID debe ser un número entero',
            'eventRecord.isStarted.required' => 'El estado de inicio es obligatorio',
            'eventRecord.isStarted.boolean' => 'El estado de inicio debe ser verdadero o falso',
            'eventRecord.isFinished.required' => 'El estado de finalización es obligatorio',
            'eventRecord.isFinished.boolean' => 'El estado de finalización debe ser verdadero o falso',

        ];
    }
}