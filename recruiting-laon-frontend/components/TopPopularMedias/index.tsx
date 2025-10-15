"use client";
import Media from "@/types/Media";
import { ArrowRight } from "phosphor-react";
import React from "react";
import MediaCard from "../MediaCard";
import { MediaType } from "@/enums/MediaType";

export default function TopPopularMedias({ mediaType, medias }: Readonly<{ mediaType: MediaType, medias: Media[] | null }>) {
    const numberOfLoadingMediasToShow = 6;

    const mediaTypeStringfied = mediaType === MediaType.Movie
        ? "FILMES"
        : "SÉRIES";

    return <div className="flex flex-col gap-3">
        <div className="flex items-center justify-between">
            <h2 className="text-sm font-semibold text-gray-500">{mediaTypeStringfied}</h2>
            <div className="w-8 h-8 rounded-full border border-gray-500 flex items-center justify-center cursor-pointer hover:bg-gray-200 transition">
                <ArrowRight size={16} weight="bold" className="text-white" />
            </div>
        </div>
        <div className="flex gap-6">{(medias ?? new Array(numberOfLoadingMediasToShow).fill(null))
            .map((media, idx) => <MediaCard key={media?.tmbdId || idx} media={media} />)
        }</div>
    </div>;
}