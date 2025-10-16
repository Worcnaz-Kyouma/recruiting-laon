<?php

namespace App\Http\Requests;

class GetMediaListsByUserRequest extends CustomFormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'user_id'  => 'required|exists:users,id'
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'user_id' => $this->route('user_id'),
        ]);
    }
}
