<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ValidarStoreProducto extends FormRequest
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
            'nombre' => 'required|unique:productos,nombre',
            'codigo' => 'required|string|unique:productos,codigo',
            'cantidad' => 'required|numeric|min:10|max:200',
            'precio' => 'required|numeric|max:200'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio',
            'nombre.unique' => 'El nombre del producto ya está en uso',
            'codigo.required' => 'El campo código es obligatorio',
            'codigo.string' => 'El campo código debe ser una cadena de texto',
            'codigo.unique' => 'El código del producto ya está en uso',
            'cantidad.required' => 'El campo cantidad es obligatorio',
            'cantidad.number' => 'El campo cantidad debe ser un número',
            'cantidad.min' => 'La cantidad mínima es 10',
            'cantidad.max' => 'La cantidad máxima es 200',
            'precio.required' => 'El campo precio es obligatorio',
            'precio.numeric' => 'El campo precio debe ser un número',
            'precio.max' => 'El precio máximo permitido es 200'
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre' => 'Nombre del producto',
            'codigo' => 'Código del producto',
            'cantidad' => 'Cantidad del producto',
            'precio' => 'Precio del producto'
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'codigo' => strtoupper(trim($this->codigo)) . '1',
        ]);
    }
}
