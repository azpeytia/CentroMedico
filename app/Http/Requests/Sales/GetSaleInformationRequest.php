<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;

class GetSaleInformationRequest extends FormRequest
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
            'startDate' => ['required', 'date_format:Y-m-d H:i:s'],
            'endDate' => ['required', 'date_format:Y-m-d H:i:s'],
            'category' => ['nullable', 'string', 'in:shift,day,week,month'],
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
            'startDate.required' => 'La fecha de inicio es obligatoria.',
            'startDate.date_format' => 'La fecha de inicio debe tener el formato Y-m-d H:i:s.',
            'endDate.required' => 'La fecha de fin es obligatoria.',
            'endDate.date_format' => 'La fecha de fin debe tener el formato Y-m-d H:i:s.',
            'category.string' => 'La categoría debe ser una cadena de texto.',
            'category.in' => 'La categoría debe ser una de las siguientes: shift, day, week, month.',
        ];
    }
}