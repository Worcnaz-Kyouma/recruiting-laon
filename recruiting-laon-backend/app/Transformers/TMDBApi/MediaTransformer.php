<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Actor;
use App\Entities\Director;
use App\Entities\Genre;
use App\Entities\Media;
use stdClass;

class MediaTransformer {
    // OBS to Code Reviewer: Genre, Actor and Director could receive its own Transformer, but i choose to keep it simple
    public static function fromExternal(stdClass $ext): Media {
        $tmdbId = $ext->id;
        $title = $ext->original_title;
        $titlePortuguese = optional(collect($ext->translations->translations)
            ->firstWhere("iso_3166_1", "BR"))
            ->data->title;
        $genres = collect($ext->genres)->map(fn($genre) => 
            new Genre($genre->id, $genre->name)
        );
        $overview = $ext->overview;
        $actors = collect($ext->credits->cast)
            ->filter(fn($mediaWorker) => $mediaWorker->known_for_department === "Acting")
            ->map(fn($actor) => 
                new Actor($actor->id, $actor->name)
            );
        $directors = collect($ext->credits->cast)
            ->filter(fn($mediaWorker) => $mediaWorker->known_for_department === "Directing")
            ->map(fn($actor) => 
                new Director($actor->id, $actor->name)
            );
        $review = $ext->vote_average;
        $reviewCount = $ext->vote_count;

        $media = new Media(
            $tmdbId, $title, $titlePortuguese,
            $genres->toArray(), $overview, $actors->toArray(),
            $directors->toArray(), $review, $reviewCount
        );

        return $media;
    }
}
