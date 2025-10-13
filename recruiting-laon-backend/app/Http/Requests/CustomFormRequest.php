<?php

namespace App\Http\Requests;

use App\Exceptions\ExpectedErrors\RequestInputsError;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CustomFormRequest extends FormRequest {
    protected function failedValidation(Validator $validator) {
        throw new RequestInputsError($validator);
    }
}
