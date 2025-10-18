<?php

namespace App\Http\Requests;

class GetMediaListsByUserRequest extends CustomFormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'user_id'  => 'required|exists:users,id',
            'page' => "integer|min:1"
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'user_id' => $this->route('user_id'),
        ]);
    }

    public function messages(): array {
        return [
            'user_id.required' => 'O id do usuário é obrigatório.',
            'user_id.exists'   => 'O usuário selecionado não existe.',

            'page.integer' => 'O número da página deve ser um número inteiro.',
            'page.min'     => 'O número da página deve ser no mínimo 1.',
        ];
    }
}
