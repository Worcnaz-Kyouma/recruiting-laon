<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetMediaListDetailsRequest extends CustomFormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'id' => 'required|exists:media_lists,id',
            'page' => "required|integer|min:1"
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}
