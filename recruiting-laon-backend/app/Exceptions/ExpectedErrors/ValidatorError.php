<?php

namespace App\Exceptions\ExpectedErrors;

use App\Exceptions\ExpectedErrors\ExpectedError;
use Illuminate\Contracts\Validation\Validator;

// TODO: I heard we can create messages in the validator itself! Maybe we can use it and ignore this class
class ValidatorError extends ExpectedError { 
    private Validator $validator;
    public function __construct(Validator $validator) {
        parent::__construct($validator->errors()->all(), 422);

        $this->validator = $validator;
    }

    // TODO: Improve that error using the failed validation rules
    public function getHttpResponseErrorMessage(): array {
        $fieldsWithError = collect($this->validator->errors()->keys());
        $failedValidationRules = collect($this->validator->failed());

        return $fieldsWithError->map(fn($field) => "O campo '$field' esta mal formatado ou faltando")->jsonSerialize();
    }
}