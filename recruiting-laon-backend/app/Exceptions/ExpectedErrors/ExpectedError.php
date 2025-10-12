<?php

namespace App\Exceptions\ExpectedErrors;

use App\Exceptions\AppError;

// Expected errors are usually user fault, or something that is expected to not work based in the used flow, all these types of errors will extend that class
abstract class ExpectedError extends AppError {
    public function __construct(string $errorOriginMessage, int $httpResponseStatusCode = 400) {
        parent::__construct($errorOriginMessage, $httpResponseStatusCode);
    }
}
