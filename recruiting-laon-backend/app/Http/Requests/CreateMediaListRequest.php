<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMediaListRequest extends CustomFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'user_id'  => 'required|exists:users,id',
            'name'     => 'required|string|max:50',

            'medias' => 'required|array',
                'medias.*.tmdb_id' => 'required|integer',
                'medias.*.media_type' => 'required|in:movie,tv-serie',
        ];
    }

    public function messages(): array {
        return [
            'user_id.required' => 'O id do usuário é obrigatório.',
            'user_id.exists'   => 'O usuário selecionado não existe.',

            'name.required' => 'O nome é obrigatório.',
            'name.string'   => 'O nome deve ser uma string.',
            'name.max'      => 'O nome não pode ter mais de 50 caracteres.',

            'medias.required'        => 'O campo medias é obrigatório.',
            'medias.array'           => 'O campo medias deve ser um array.',
            'medias.*.tmdb_id.required' => 'O TMDB ID de cada mídia é obrigatório.',
            'medias.*.tmdb_id.integer'  => 'O TMDB ID de cada mídia deve ser um número inteiro.',
            'medias.*.media_type.required' => 'O tipo de mídia de cada item é obrigatório.',
            'medias.*.media_type.in'      => 'O tipo de mídia deve ser "movie" ou "tv-serie".',
        ];
    }
}
