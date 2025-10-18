<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends CustomFormRequest {
    public function rules(): array {
        return [
            'name'     => 'required|string|max:50',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.max'      => 'O nome não pode ter mais de 50 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Esse e-mail já está em uso.',

            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            
            'password_confirmation.required' => 'A confirmação da senha é obrigatória.',
            'password_confirmation.same' => 'As senhas digitadas não coincidem.',
        ];
    }
}
