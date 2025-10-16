<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogoutRequest extends CustomFormRequest {
    public function rules(): array {
        return [
            'id' => 'required|exists:users,id',
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}
