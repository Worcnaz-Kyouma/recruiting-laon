<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

abstract class AppError extends Exception {
    /**
     * @var string|array<string>
     */
    private string | array $errorOriginMessage;
    protected int $httpResponseStatusCode;

    /**
     * @param string|array<string> $errorOriginMessage
     */
    public function __construct(string | array $errorOriginMessage, int $httpResponseStatusCode) {
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
    /**
     * @return string | array<string>
     */
    abstract protected function getHttpResponseErrorMessage(): string | array;
}
