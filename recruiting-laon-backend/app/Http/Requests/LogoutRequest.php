<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogoutRequest extends CustomFormRequest {
    public function rules(): array {
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }
}
