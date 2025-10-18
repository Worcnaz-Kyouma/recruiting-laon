<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteMediaListRequest extends CustomFormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'id' => 'required|exists:media_lists,id'
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }

    public function messages(): array {
        return [
            'id.required' => 'O id da lista é obrigatório.',
            'id.exists'   => 'A lista de mídia selecionada não existe.',
        ];
    }
}
