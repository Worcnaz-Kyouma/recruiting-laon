<?php

namespace App\Http\Requests;

class GetMediaListDetailsRequest extends CustomFormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'id' => 'required|min:1',
            'page' => "required|integer|min:1"
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }

    public function messages(): array {
    return [
        'id.required' => 'O id é obrigatório.',
        'id.min'      => 'O id deve ser no mínimo 1.',

        'page.required' => 'O número da página é obrigatório.',
        'page.integer'  => 'O número da página deve ser um número inteiro.',
        'page.min'      => 'O número da página deve ser no mínimo 1.',
    ];
}
}
