<?php

namespace App\Http\Requests;

class AddMediasIntoMediaListRequest extends CustomFormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'id' => 'required|exists:media_lists,id',
            'medias' => 'required|array',
                'medias.*.tmdb_id' => 'required|integer',
                'medias.*.media_type' => 'required|in:movie,tv-serie',
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

            'medias.required' => 'O campo "medias" é obrigatório.',
            'medias.array' => 'O campo "medias" deve ser um array.',

            'medias.*.tmdb_id.required' => 'O TMDB ID de cada mídia é obrigatório.',
            'medias.*.tmdb_id.integer' => 'O TMDB ID de cada mídia deve ser um número.',
            'medias.*.media_type.required' => 'O tipo de mídia de cada item é obrigatório.',
            'medias.*.media_type.in' => 'O tipo de mídia deve ser "movie" ou "tv-serie".'
        ];
    }
}
