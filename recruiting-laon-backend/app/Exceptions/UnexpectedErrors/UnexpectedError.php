<?php

namespace App\Exceptions\UnexpectedErrors;

use App\Exceptions\AppError;
use Exception;

// Unexpected errors are usually errors caused by the application itself, like database communication and api misscomminication
class UnexpectedError extends AppError {
    public function __construct(string $errorOriginMessage, int $httpResponseStatusCode = 500) {
        parent::__construct($errorOriginMessage, $httpResponseStatusCode);
    }

    protected function getHttpResponseErrorMessage(): string {
        return "An unexpected error occurred.";
    }
}
