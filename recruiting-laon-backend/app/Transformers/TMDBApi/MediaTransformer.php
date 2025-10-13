<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Actor;
use App\Entities\Director;
use App\Entities\Genre;
use App\Entities\Media;
use stdClass;

abstract class MediaTransformer {
    public static function fromExternal(stdClass $ext): Media {
        $tmdbId = $ext->id;
        $title = self::titleFromExternal($ext);
        $titlePortuguese = self::titlePortugueseFromExternalTranslations($ext);
        $genres = self::genresFromExternal($ext);
        $overview = $ext->overview;
        $actors = self::actorsFromExternalCredits($ext);
        $directors = self::directorsFromExternalCredits($ext);
        $review = $ext->vote_average;
        $reviewCount = $ext->vote_count;
        $tmdbImageBaseUrl = config('tmdb.image_base_url');
        $posterImgUrl = "$tmdbImageBaseUrl/$ext->poster_path";

        $movie = new Media(
            $tmdbId, $title, $titlePortuguese,
            $genres, $overview, $actors,
            $directors, $review, $reviewCount, $posterImgUrl
        );

        return $movie;
    }

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

    protected static function titleFromExternal(stdClass $ext): string {
        // Implemented in subclasses, can't be abstract cause PHP doesn't understand the implementation will come from subclasses
        return "";
    }
}
