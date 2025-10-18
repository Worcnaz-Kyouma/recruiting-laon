<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediasByTitleRequest extends CustomFormRequest {
    public function rules(): array {
        return [
            "title" => "required|string|max:100",
            "page" => "required|integer|min:1"
        ];
    }

    
    public function messages(): array {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.string'   => 'O título deve ser uma string.',
            'title.max'      => 'O título não pode ter mais de 100 caracteres.',

            'page.required' => 'O número da página é obrigatório.',
            'page.integer'  => 'O número da página deve ser um número inteiro.',
            'page.min'      => 'O número da página deve ser no mínimo 1.',
        ];
    }
}
