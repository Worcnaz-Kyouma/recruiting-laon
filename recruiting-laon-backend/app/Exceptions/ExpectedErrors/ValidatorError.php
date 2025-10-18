<?php

namespace App\Exceptions\ExpectedErrors;

use App\Exceptions\ExpectedErrors\ExpectedError;
use Illuminate\Contracts\Validation\Validator;

// TODO: I heard we can create messages in the validator itself! Maybe we can use it and ignore this class
class ValidatorError extends ExpectedError { 
    private Validator $validator;
    public function __construct(Validator $validator) {
        parent::__construct(422, null, $validator->errors()->all());

        $this->validator = $validator;
    }

    // TODO: Improve that error using the failed validation rules
    public function getHttpResponseErrorMessage(): array {
        $errorsMessages = $this->validator->errors()->messages();
        $messages = array_merge(...array_values($errorsMessages));

        return $messages;
    }
}