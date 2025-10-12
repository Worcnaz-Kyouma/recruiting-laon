<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

// App Errors involve both the expected errors(user errors most of the cases) and unexpected ones(like database missing or api timeout), all errors app knowns it possible to happen.
abstract class AppError extends Exception {
    private string $errorOriginMessage;
    protected int $httpResponseStatusCode;

    public function __construct(string $errorOriginMessage, int $httpResponseStatusCode) {
        $this->errorOriginMessage = $errorOriginMessage;
        $this->httpResponseStatusCode = $httpResponseStatusCode;
    }

    public function getHttpResponse(): JsonResponse {
        $jsonBody = [
            "error"=> $this->getHttpResponseErrorMessage()
        ];
        if(app()->environment("local", "development"))
            $jsonBody["errorOrigin"] = $this->errorOriginMessage;

        $response = response()->json($jsonBody, $this->httpResponseStatusCode);

        return $response;
    }
    abstract protected function getHttpResponseErrorMessage(): string;
}
