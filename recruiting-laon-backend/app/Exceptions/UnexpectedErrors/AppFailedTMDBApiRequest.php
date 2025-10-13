<?php

namespace App\Exceptions\UnexpectedErrors;

class AppFailedTMDBApiRequest extends UnexpectedError { 
    public function __construct(string $errorOriginMessage) {
        parent::__construct($errorOriginMessage);
    }

    public function getHttpResponseErrorMessage(): string {
        return "Aplicação falhou ao se comunicar com a API do TMDB.";
    }
}