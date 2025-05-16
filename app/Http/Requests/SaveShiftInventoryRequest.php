<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveShiftInventoryRequest extends FormRequest
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
            '*.productId' => 'required|integer',
            '*.shiftId' => 'required|integer',
            '*.shiftDate' => 'required|date',
            '*.productStock' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            '*.productId.required' => 'El producto es obligatorio',
            '*.shiftId.required' => 'El turno es obligatorio',
            '*.shiftDate.required' => 'La fecha es obligatoria',
            '*.productStock.required' => 'El stock es obligatorio',
        ];
    }
}