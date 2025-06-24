<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidarEditUser extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('usuario')->id ?? null;

        return [
            'name' => 'required|string|max:255|min:2',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'password_confirmation' => 'nullable|string|min:8',
            'toggle_verification' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del usuario es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'name.min' => 'El nombre debe tener al menos 2 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            'email.unique' => 'Este correo electrónico ya está registrado por otro usuario.',

            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'password.regex' => 'La nueva contraseña debe contener al menos una mayúscula, una minúscula y un número.',

            'password_confirmation.string' => 'La confirmación debe ser una cadena de texto.',
            'password_confirmation.min' => 'La confirmación debe tener al menos 8 caracteres.',

            'toggle_verification.boolean' => 'El estado de verificación debe ser verdadero o falso.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre del usuario',
            'email' => 'correo electrónico',
            'password' => 'nueva contraseña',
            'password_confirmation' => 'confirmación de contraseña',
            'toggle_verification' => 'estado de verificación',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim($this->name),
            'email' => strtolower(trim($this->email)),
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Si se proporciona contraseña, debe tener confirmación
            if ($this->filled('password') && !$this->filled('password_confirmation')) {
                $validator->errors()->add('password_confirmation', 'La confirmación de contraseña es obligatoria cuando se proporciona una nueva contraseña.');
            }
        });
    }
}
