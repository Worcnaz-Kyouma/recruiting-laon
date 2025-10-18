<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaDetailsRequest extends CustomFormRequest {

    public function rules(): array {
        return [
            "id" => "required|integer|min:1",
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }

    public function messages(): array {
        return [
            'id.required' => 'O ID é obrigatório.',
            'id.integer'  => 'O ID deve ser um número inteiro.',
            'id.min'      => 'O ID deve ser no mínimo 1.',
        ];
    }
}
