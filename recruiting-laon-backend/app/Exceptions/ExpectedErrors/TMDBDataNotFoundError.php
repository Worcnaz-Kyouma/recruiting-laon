<?php

namespace App\Exceptions\ExpectedErrors;

use App\Exceptions\ExpectedErrors\ExpectedError;

class TMDBDataNotFoundError extends ExpectedError { 
    public function __construct(string $errorOriginMessage) {
        parent::__construct(404, null, $errorOriginMessage);
    }

    public function getHttpResponseErrorMessage(): string {
        return "TMDB API não encontrou as informações consultadas.";
    }
}