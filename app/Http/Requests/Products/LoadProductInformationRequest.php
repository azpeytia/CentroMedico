<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class LoadProductInformationRequest extends FormRequest
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
            'gtinBarCode.string' => 'El :attribute debe ser un número entero',
            'gtinBarCode.exists' => 'El :attribute no existe en la base de datos',
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
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'gtinBarCode' => (int) data_get($this->input('productQuantity'), 'gtinBarCode'),
        ]);
    }
}