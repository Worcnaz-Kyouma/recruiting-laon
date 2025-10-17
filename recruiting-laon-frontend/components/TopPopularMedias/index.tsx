"use client";
import Media from "@/types/Media";
import React from "react";
import MediaCard from "../MediaCard";
import { useRouter } from "next/navigation";
import { MediaType } from "@/enums/MediaType";
import ArrowButton from "../ArrowButton";
import useUser from "@/hooks/useUser";
import { useAppStore } from "@/providers/user-store-provider";
import MediaCardsGrid from "../MediaCardsGrid";

export default function TopPopularMedias({ medias }: Readonly<{ medias: Media[] | undefined }>) {
    const router = useRouter();
    const user = useUser();
    const { setIsUnauthorizedNavBlockModalOpen } = useAppStore(state => state);   
    const numberOfLoadingMediasToShow = 6;

    const mediaType = medias && "seasons" in medias[0]
        ? MediaType.TVSerie
        : MediaType.Movie;

    const mediaTypeStringfied = mediaType
        ? "SÉRIES"
        : "FILMES";

    const handleOpenMediaSearcher = () => {
        if(!user) {
            setIsUnauthorizedNavBlockModalOpen(true);
            return;
        }

        router.push(`/${mediaType}`);
    }

    return <div className="flex flex-col gap-3">
        <div className="flex items-center justify-between">
            <h2 className="text-sm font-semibold text-gray-500">{mediaTypeStringfied}</h2>
            <ArrowButton orientation="right" onClick={handleOpenMediaSearcher} />
        </div>
        <MediaCardsGrid medias={medias ?? new Array(numberOfLoadingMediasToShow).fill(undefined)}/>
    </div>;
}