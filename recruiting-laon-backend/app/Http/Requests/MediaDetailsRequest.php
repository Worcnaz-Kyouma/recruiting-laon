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
}
