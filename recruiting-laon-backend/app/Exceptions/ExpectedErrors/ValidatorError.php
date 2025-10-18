<?php

namespace App\Exceptions\ExpectedErrors;

use App\Exceptions\ExpectedErrors\ExpectedError;
use Illuminate\Contracts\Validation\Validator;

class ValidatorError extends ExpectedError { 
    private Validator $validator;
    public function __construct(Validator $validator) {
        parent::__construct(422, null, $validator->errors()->all());

        $this->validator = $validator;
    }

    public function getHttpResponseErrorMessage(): array {
        $errorsMessages = $this->validator->errors()->messages();
        $messages = array_merge(...array_values($errorsMessages));

        return $messages;
    }
}