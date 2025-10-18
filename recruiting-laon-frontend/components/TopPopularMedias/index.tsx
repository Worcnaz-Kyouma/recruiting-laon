import Media from "@/types/Media";
import React from "react";
import { MediaType } from "@/enums/MediaType";
import MediasContainer from "../MediasContainer";

export default function TopPopularMedias({ medias }: Readonly<{ medias: Media[] | undefined }>) {
    const numberOfLoadingMediasToShow = 6;

    const mediaType = (medias && "seasons" in medias[0])
        ? MediaType.TVSerie
        : MediaType.Movie;

    const mediaTypeStringfied = mediaType === MediaType.TVSerie
        ? "SÉRIES"
        : "FILMES";

    return <MediasContainer 
        title={mediaTypeStringfied} 
        medias={medias ?? new Array(numberOfLoadingMediasToShow).fill(undefined)}
        redirectUrl={`/${mediaType}`}
    />;
}