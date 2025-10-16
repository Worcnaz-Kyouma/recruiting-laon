<?php

namespace App\Http\Requests;

class ListingMethodsRequest extends CustomFormRequest {
    public function rules(): array {
        return [
            'media_type' => 'required|in:movie,tv-serie'
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'media_type' => $this->route('media_type'),
        ]);
    }
}
