<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductStockRequest extends FormRequest
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
            'gtinBarCode' => ['required', 'integer', 'exists:products,gtin_code'],
            'quantity' => ['required', 'integer', 'min:1'],
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
            'gtinBarCode.required' => 'El :attribute es requerido',
            'gtinBarCode.integer' => 'El :attribute debe ser un número entero',
            'gtinBarCode.exists' => 'El :attribute no existe en la base de datos',
            'quantity.required' => 'La :attribute es requerida',
            'quantity.integer' => 'La :attribute debe ser un número entero',
            'quantity.min' => 'La :attribute debe ser al menos 1',
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
            'gtinBarCode' => 'código de barras',
            'quantity' => 'cantidad',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'gtinBarCode' => (int) data_get($this->input('productQuantity'), 'gtinBarCode'),
            'quantity' => (int) data_get($this->input('productQuantity'), 'quantity'),
        ]);
    }
}