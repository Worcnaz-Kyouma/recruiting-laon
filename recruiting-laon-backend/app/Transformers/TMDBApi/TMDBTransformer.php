<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Entity;
use App\Exceptions\UnexpectedErrors\TMDBTransformerFailed;
use Exception;

abstract class TMDBTransformer {
    abstract protected static function fromExternal(array $ext): ?Entity;

    public static function tryFromExternal(array $ext): ?Entity {
        try {
            return static::fromExternal($ext);
        } catch (Exception $th) {
            throw new TMDBTransformerFailed($th->getMessage(), static::class);
        }
    }
}
