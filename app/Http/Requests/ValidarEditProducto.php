<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ValidarEditProducto extends FormRequest
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
        $productoId = $this->route('producto')->id ?? null;

        return [
            'nombre' => 'required|unique:productos,nombre,' . $productoId,
            'codigo' => 'required|string|max:5|unique:productos,codigo,' . $productoId,
            'cantidad' => 'required|numeric',
            'precio' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.unique' => 'El nombre del producto ya está en uso.',
            'codigo.required' => 'El código del producto es obligatorio.',
            'codigo.string' => 'El código debe ser una cadena de texto.',
            'codigo.max' => 'El código no puede tener más de 5 caracteres.',
            'codigo.unique' => 'El código del producto ya está en uso.',
            'cantidad.required' => 'La cantidad del producto es obligatoria.',
            'cantidad.numeric' => 'La cantidad debe ser un número.',
            'precio.required' => 'El precio del producto es obligatorio.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre' => 'nombre del producto',
            'codigo' => 'código del producto',
            'cantidad' => 'cantidad del producto',
            'precio' => 'precio del producto',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'codigo' => strtoupper(trim($this->codigo)),
        ]);
    }
}
