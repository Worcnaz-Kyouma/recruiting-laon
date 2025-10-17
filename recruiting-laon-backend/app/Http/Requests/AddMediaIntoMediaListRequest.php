<?php

namespace App\Http\Requests;

class AddMediaIntoMediaListRequest extends CustomFormRequest {
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
}
