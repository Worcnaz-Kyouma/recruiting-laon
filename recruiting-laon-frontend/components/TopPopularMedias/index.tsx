"use client";
import Media from "@/types/Media";
import { ArrowRight } from "phosphor-react";
import React from "react";
import MediaCard from "../MediaCard";
import { useRouter } from "next/navigation";
import { MediaType } from "@/enums/MediaType";

export default function TopPopularMedias({ medias }: Readonly<{ medias: Media[] | undefined }>) {
    const router = useRouter();
    const numberOfLoadingMediasToShow = 6;

    const mediaType = medias && "seasons" in medias[0]
        ? MediaType.TVSerie
        : MediaType.Movie;

    const mediaTypeStringfied = mediaType
        ? "SÉRIES"
        : "FILMES";

    const handleOpenMediaSearcher = () => {
        router.push(`/${mediaType}`);
    }

    return <div className="flex flex-col gap-3">
        <div className="flex items-center justify-between">
            <h2 className="text-sm font-semibold text-gray-500">{mediaTypeStringfied}</h2>
            <div className="w-8 h-8 rounded-full border border-gray-500 flex items-center justify-center cursor-pointer hover:bg-gray-200 transition" 
                onClick={handleOpenMediaSearcher}
            >
                <ArrowRight size={16} weight="bold" className="text-white" />
            </div>
        </div>
        <div className="flex gap-6">{(medias ?? new Array(numberOfLoadingMediasToShow).fill(undefined))
            .map((media, idx) => <MediaCard key={media?.tmdbId || idx} media={media} />)
        }</div>
    </div>;
}