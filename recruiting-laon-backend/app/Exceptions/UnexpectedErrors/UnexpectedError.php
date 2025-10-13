<?php

namespace App\Exceptions\UnexpectedErrors;

use App\Exceptions\AppError;

// Unexpected errors are usually errors caused by the application itself, like database communication and api misscomminication
class UnexpectedError extends AppError {
    /**
     * @param string|array<string> $errorOriginMessage
     */
    public function __construct(string | array $errorOriginMessage, int $httpResponseStatusCode = 500) {
        parent::__construct($errorOriginMessage, $httpResponseStatusCode);
    }

    protected function getHttpResponseErrorMessage(): string {
        return "Um erro inesperado ocorreu.";
    }
}
