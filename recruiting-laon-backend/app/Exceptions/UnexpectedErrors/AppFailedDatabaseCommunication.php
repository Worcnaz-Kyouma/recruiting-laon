<?php

namespace App\Exceptions\UnexpectedErrors;

class AppFailedDatabaseCommunication extends UnexpectedError { 
    public function __construct(string $errorOriginMessage) {
        parent::__construct($errorOriginMessage);
    }

    public function getHttpResponseErrorMessage(): string {
        return "Aplicação falhou ao se comunicar com o banco de dados.";
    }
}