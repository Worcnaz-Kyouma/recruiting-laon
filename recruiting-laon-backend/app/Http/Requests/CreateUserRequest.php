<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends CustomFormRequest {
    public function rules(): array {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Esse e-mail já está em uso.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password_confirmation.same' => 'A confirmação da senha deve ser igual à senha.',
        ];
    }
}
