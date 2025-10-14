<?php

namespace App\Transformers\TMDBApi;

use App\Entities\TMDBError;

class TMDBErrorTransformer extends TMDBTransformer {
    protected static function fromExternal(array $ext): TMDBError {
        $statusCode = $ext['status_code'];
        $statusMessage = $ext['status_message'];

        return new TMDBError($statusCode, $statusMessage);
    }
}
