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
            'name'     => 'required|string|max:255',

            'medias' => 'required|array',
                'medias.*.tmdb_id' => 'required|integer',
                'medias.*.media_type' => 'required|in:movie,tv-serie',
        ];
    }
}
