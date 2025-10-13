<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Actor;
use App\Entities\Director;
use App\Entities\Genre;
use App\Entities\Media;
use stdClass;

class MediaTransformer {
    // OBS to Code Reviewer: I didn't made a fromExternal generic here because Movie and TVSeries are not generics in TMDB. For example, a name of a movie media there is "title", a tv show is "name". The number of different fields are low, but i prefered to keep it explicit, accepting redudancy to make the code more prepared if TMDB change something in the future.
    protected static function titlePortugueseFromExternalTranslations(stdClass $ext): ?string {
        if(!isset($ext->translations)) return null;

        return optional(collect($ext->translations->translations)
            ->firstWhere("iso_3166_1", "BR"))
            ->data->title;
    }

    protected static function genresFromExternal(stdClass $ext): ?array {
        if(!isset($ext->genres)) return null;

        return collect($ext->genres)->map(fn($genre) => 
            new Genre($genre->id, $genre->name)
        )->toArray();
    }

    protected static function actorsFromExternalCredits(stdClass $ext): ?array {
        if(!isset($ext->credits)) return null;

        return collect($ext->credits->cast)
            ->filter(fn($mediaWorker) => $mediaWorker->known_for_department === "Acting")
            ->map(fn($actor) => 
                new Actor($actor->id, $actor->name)
            )->toArray();
    }

    protected static function directorsFromExternalCredits(stdClass $ext): ?array {
        if(!isset($ext->credits)) return null;

        return optional(collect($ext->credits->cast)
            ->filter(fn($mediaWorker) => $mediaWorker->known_for_department === "Directing")
            ->map(fn($actor) => 
                new Director($actor->id, $actor->name)
            )->toArray());
    }
}
