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
        return "Transformer {$this->tmdbTransformerClassName} failed to parse external API data into internal entity data.";
    }
}