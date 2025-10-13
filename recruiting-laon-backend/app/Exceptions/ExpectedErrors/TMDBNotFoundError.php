<?php

namespace App\Exceptions\UnexpectedErrors;

use App\Exceptions\ExpectedErrors\ExpectedError;

class TMDBNotFoundError extends ExpectedError { 
    public function __construct(string $errorOriginMessage) {
        parent::__construct($errorOriginMessage);
    }

    public function getHttpResponseErrorMessage(): string {
        return "TMDB API not found error occurred.";
    }
}