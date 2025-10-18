<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Actor;
use App\Entities\Director;
use App\Entities\Genre;
use App\Entities\TMDBMedia;
use DateTime;

// OBS to Code Reviewer: Genre, Actor and Director could receive its own Transformer, but i choose to keep it simple
// TODO: get portuguese overview from translations, and wrap all brazilian fields into an whole object
class TMDBMediaTransformer extends TMDBTransformer {
    protected static function fromExternal(array $ext): TMDBMedia {
        $tmdbId = $ext['id'];
        $title = static::titleFromExternal($ext);
        $titlePortuguese = static::titlePortugueseFromExternalTranslations($ext);
        $releaseDate = array_key_exists("release_date", $ext) && $ext["release_date"]
            ? new DateTime($ext["release_date"])
            : null;
        $genres = static::genresFromExternal($ext);
        $overview = $ext['overview'] ?: null;
        $actors = static::actorsFromExternalCredits($ext);
        $directors = static::directorsFromExternalCredits($ext);
        $review = array_key_exists("vote_average", $ext) 
            ? $ext['vote_average']
            : null;
        $reviewCount = array_key_exists("vote_count", $ext) 
            ? $ext["vote_count"]
            : null;
        
        $tmdbImageBaseUrl = config('tmdb.image_base_url');
        $posterImgUrl = array_key_exists("poster_path", $ext) && $ext['poster_path']
            ? "$tmdbImageBaseUrl{$ext['poster_path']}"
            : null;

        $youtubeTrailerVideoUrl = static::mostRecentYoutubeTrailerFromExternal($ext);

        $movie = new TMDBMedia(
            $tmdbId, $title, $titlePortuguese, $releaseDate,
            $genres, $overview, $actors,
            $directors, $review, $reviewCount, $posterImgUrl,
            $youtubeTrailerVideoUrl
        );

        return $movie;
    }

    protected static function titleFromExternal(array $ext): string {
        return $ext['original_title'];
    }

    protected static function titlePortugueseFromExternalTranslations(array $ext): ?string {
        if(!isset($ext['translations'])) return null;

        return data_get(
            collect($ext['translations']["translations"])->firstWhere("iso_3166_1", "BR"),
            'data.title'
        );
    }
    
    protected static function genresFromExternal(array $ext): ?array {
        if(!isset($ext['genres'])) return null;

        return collect($ext['genres'])->map(fn($genre) => 
            new Genre($genre["id"], $genre["name"])
        )->toArray();
    }
    
    protected static function actorsFromExternalCredits(array $ext): ?array {
        if(!isset($ext['credits'])) return null;

        return collect($ext['credits']["cast"])
            ->filter(fn($mediaWorker) => $mediaWorker["known_for_department"] === "Acting")
            ->map(fn($actor) => 
                new Actor($actor["id"], $actor["name"])
            )->values()
            ->toArray();
    }

    protected static function directorsFromExternalCredits(array $ext): ?array {
        if(!isset($ext['credits'])) return null;

        return collect($ext['credits']["crew"])
            ->filter(fn($mediaWorker) => $mediaWorker["known_for_department"] === "Directing")
            ->map(fn($actor) => 
                new Director($actor["id"], $actor["name"])
            )->values()
            ->toArray();
    }

    protected static function mostRecentYoutubeTrailerFromExternal(array $ext): ?string {
        if(!isset($ext['videos'])) return null;

        $mostRecentYoutubeTrailer = collect($ext['videos']["results"])
            ->filter(fn($video) => 
                $video["site"] === "YouTube" && 
                $video["type"] === "Trailer" &&
                $video["official"]
            )
            ->sortByDesc('published_at')
            ->first();
        
        $youtubeVideoCode = $mostRecentYoutubeTrailer['key'] ?? null;
        if($youtubeVideoCode === null) return null;

        $youtubeBaselink = "https://www.youtube.com";
        $youtubeLink = "{$youtubeBaselink}/embed/{$youtubeVideoCode}";

        return $youtubeLink;
    }
}
