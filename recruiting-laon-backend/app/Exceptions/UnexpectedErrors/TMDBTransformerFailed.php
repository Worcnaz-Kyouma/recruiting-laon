<?php

namespace App\Exceptions\UnexpectedErrors;

use App\Transformers\TMDBApi\TMDBTransformer;

class TMDBTransformerFailed extends UnexpectedError { 
    private string $tmdbTransformerClassName;

    /**
     * @param class-string<TMDBTransformer> $tmdbTransformer
     */
    public function __construct(string $errorOriginMessage, string $tmdbTransformer) {
        parent::__construct($errorOriginMessage);
        
        $this->tmdbTransformerClassName = $tmdbTransformer;
    }

    public function getHttpResponseErrorMessage(): string {
        return "Transformer {$this->tmdbTransformerClassName} falhou em converter dados da API externa em dados internos da aplicação.";
    }
}