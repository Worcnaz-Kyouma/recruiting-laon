<?php

namespace App\Http\Requests;

use App\Exceptions\ExpectedErrors\ValidatorError;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CustomFormRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }
    
    protected function failedValidation(Validator $validator) {
        throw new ValidatorError($validator);
    }
}
