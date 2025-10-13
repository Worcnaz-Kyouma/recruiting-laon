<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Entity;
use App\Exceptions\UnexpectedErrors\TMDBTransformerFailed;
use Exception;
use stdClass;

abstract class TMDBTransformer {
    abstract protected static function fromExternal(stdClass $ext): Entity;

    public static function tryFromExternal(stdClass $ext): Entity {
        try {
            return static::fromExternal($ext);
        } catch (Exception $th) {
            throw new TMDBTransformerFailed($th->getMessage(), static::class);
        }
    }
}
