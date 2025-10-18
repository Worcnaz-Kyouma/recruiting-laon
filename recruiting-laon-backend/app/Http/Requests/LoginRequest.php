<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends CustomFormRequest {
    public function rules(): array {
        return [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array {
        return [
            'email.required' => 'O e-mail é obrigatório.',
            'email.string'   => 'O e-mail deve ser uma string.',
            'email.email'    => 'O e-mail deve ser um endereço válido.',
            'email.exists'   => 'O e-mail informado não está cadastrado.',

            'password.required' => 'A senha é obrigatória.',
            'password.string'   => 'A senha deve ser uma string.',
            'password.min'      => 'A senha deve ter pelo menos 8 caracteres.',
        ];
    }
}
