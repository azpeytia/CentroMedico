<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveSaleInformationRequest extends FormRequest
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
            'patient_id' => ['required', 'numeric'],
            'shift_id' => ['required', 'numeric'],
            'user_id' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'status' => ['required', 'string'],
            'payment_method' => ['required', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'is_suspended' => ['sometimes', 'boolean'],
            'is_deleted' => ['sometimes', 'boolean'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => ['required', 'numeric', 'exists:products,id'],
            'products.*.quantity' => ['required', 'numeric', 'min:1'],
            'products.*.unit_price' => ['required', 'numeric', 'min:0'],
            'products.*.subtotal' => ['required', 'numeric', 'min:0'],
            'products.*.is_active' => ['sometimes', 'boolean'],
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
            'patient_id.required' => 'El paciente es obligatorio',
            'patient_id.numeric' => 'El paciente debe ser un número',
            'shift_id.required' => 'El turno es obligatorio',
            'shift_id.numeric' => 'El turno debe ser un número',
            'user_id.required' => 'El usuario es obligatorio',
            'user_id.numeric' => 'El usuario debe ser un número',
            'total.required' => 'El total es obligatorio',
            'total.numeric' => 'El total debe ser un número',
            'status.required' => 'El estado es obligatorio',
            'status.string' => 'El estado debe ser una cadena de texto',
            'payment_method.required' => 'El método de pago es obligatorio',
            'payment_method.string' => 'El método de pago debe ser una cadena de texto',
            'is_active.boolean' => 'El campo activo debe ser verdadero o falso',
            'is_suspended.boolean' => 'El campo suspendido debe ser verdadero o falso',
            'is_deleted.boolean' => 'El campo eliminado debe ser verdadero o falso',
            'products.required' => 'Debe agregar al menos un producto a la venta.',
            'products.array' => 'El formato de productos no es válido.',
            'products.min' => 'Debe agregar al menos un producto a la venta.',
            'products.*.product_id.required' => 'El producto es obligatorio.',
            'products.*.product_id.numeric' => 'El ID del producto debe ser numérico.',
            'products.*.product_id.exists' => 'El producto seleccionado no existe.',
            'products.*.quantity.required' => 'La cantidad es obligatoria.',
            'products.*.quantity.numeric' => 'La cantidad debe ser un número.',
            'products.*.quantity.min' => 'La cantidad debe ser al menos 1.',
            'products.*.unit_price.required' => 'El precio unitario es obligatorio.',
            'products.*.unit_price.numeric' => 'El precio unitario debe ser un número.',
            'products.*.unit_price.min' => 'El precio unitario no puede ser negativo.',
            'products.*.subtotal.required' => 'El subtotal es obligatorio.',
            'products.*.subtotal.numeric' => 'El subtotal debe ser un número.',
            'products.*.subtotal.min' => 'El subtotal no puede ser negativo.',
            'products.*.is_active.boolean' => 'El campo activo del producto debe ser verdadero o falso.',
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
            'patient_id' => 'paciente',
            'shift_id' => 'turno',
            'user_id' => 'usuario',
            'total' => 'total',
            'status' => 'estatus',
            'payment_method' => 'método de pago',
            'is_active' => 'activo',
            'is_suspended' => 'suspendido',
            'is_deleted' => 'eliminado',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $products = $this->input('products', []);
            $productIds = array_column($products, 'product_id');
            if (count($productIds) !== count(array_unique($productIds))) {
                $validator->errors()->add('products', 'No se permiten productos duplicados en la venta.');
            }
        });
    }
}