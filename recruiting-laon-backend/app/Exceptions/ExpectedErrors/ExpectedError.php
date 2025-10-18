<?php

namespace App\Exceptions\ExpectedErrors;

use App\Exceptions\AppError;

// Expected errors are usually user fault, or something that is expected to not work based in the used flow, all these types of errors will extend that class
class ExpectedError extends AppError {
    private ?string $errorMessage = null;

    /**
     * @param string|array<string> $errorOriginMessage
     */
    public function __construct(int $httpResponseStatusCode = 400, ?string $errorMessage = null, string | array $errorOriginMessage = "Erro tratado e esperado pela aplicação") {
        parent::__construct($errorOriginMessage, $httpResponseStatusCode);
        $this->errorMessage = $errorMessage;
    }

    public function getHttpResponseErrorMessage(): string | array {
        return $this->errorMessage;
    }
}
