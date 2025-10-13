<?php

namespace App\Transformers\TMDBApi;

use App\Entities\TMDBError;
use App\Entities\TVEpisode;
use App\Entities\TVSeason;
use stdClass;

class TMDBErrorTransformer extends TMDBTransformer {
    protected static function fromExternal(stdClass $ext): TMDBError {
        $statusCode = $ext->status_code;
        $statusMessage = $ext->status_message;

        return new TMDBError($statusCode, $statusMessage);
    }
}
