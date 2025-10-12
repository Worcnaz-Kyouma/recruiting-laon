<?php

namespace App\Exceptions\UnexpectedErrors;

class AppFailedTMDBApiRequest extends UnexpectedError { 
    public function __construct(string $errorOriginMessage) {
        parent::__construct($errorOriginMessage);
    }

    public function getHttpResponseErrorMessage(): string {
        return "Failed to communicate with TMDB Api";
    }
}