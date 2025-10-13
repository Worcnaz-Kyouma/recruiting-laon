<?php

namespace App\Exceptions\UnexpectedErrors;

use App\Transformers\TMDBApi\TMDBTransformer;

class TMDBInternalError extends UnexpectedError { 
    public function __construct(string $errorOriginMessage) {
        parent::__construct($errorOriginMessage);
    }

    public function getHttpResponseErrorMessage(): string {
        return "API do TMDB gerou um erro interno.";
    }
}