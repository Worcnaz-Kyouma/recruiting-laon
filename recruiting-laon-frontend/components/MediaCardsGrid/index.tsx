"use client";
import Media from "@/types/Media";
import React from "react";
import MediaCard from "../MediaCard";

interface MediaCardsGridProps {
    medias: (Media | undefined)[]
}
export default function MediaCardsGrid({ medias }: MediaCardsGridProps) {
    return <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6 bg-">{medias.map((media, idx) => 
        <MediaCard key={media?.tmdbId || idx} media={media} />
    )}</div>;
}