<?php

namespace App\Http\Requests;

class DeleteMediasFromMediaListRequest extends CustomFormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'id' => 'required|exists:media_lists,id',
            'medias' => 'required|array',
                'medias.*.id' => 'required|integer',
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

            'medias.required'      => 'O campo medias é obrigatório.',
            'medias.array'         => 'O campo medias deve ser um array.',
            'medias.*.id.required' => 'O id de cada mídia é obrigatório.',
            'medias.*.id.integer'  => 'O id de cada mídia deve ser um número inteiro.',
        ];
    }
}
