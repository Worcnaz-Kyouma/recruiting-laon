<?php

namespace App\Exceptions\UnexpectedErrors;

use Illuminate\Database\QueryException;

class DatabaseError extends UnexpectedError { 
    public function __construct(string $errorOriginMessage) {
        parent::__construct($errorOriginMessage);
    }

    public function getHttpResponseErrorMessage(): string {
        return "Aplicação falhou na comunicação com o banco de dados.";
    }

    public static function isDuplicateEntry(QueryException $e): bool {
        return isset($e->errorInfo[1]) && $e->errorInfo[1] === 1062;
    }
}