"use client"
import { MediaType } from "@/enums/MediaType";
import useUser from "@/hooks/useUser";
import { useAppStore } from "@/providers/user-store-provider";
import Media from "@/types/Media";
import Image from "next/image";
import { useRouter } from "next/navigation";
import React, { useState } from "react";

const MediaCardSkeletonLoader = () => <div className="w-full max-w-md aspect-[780/1170] cursor-pointer hover:opacity-80 transition bg-gray-300 animate-pulse" />;

// TODO: Handle no poster media
// TODO: Wait until image is loaded
export default function MediaCard({ media }: Readonly<{ media: Media | undefined }>) {
    const router = useRouter();
    const user = useUser();
    const { setIsUnauthorizedNavBlockModalOpen } = useAppStore(state => state);
    const isTVSerieMedia = media && "seasons" in media;

    const mediaType = isTVSerieMedia
        ? MediaType.TVSerie
        : MediaType.Movie;

    const openMediaDetails = () => {
        if(!user) {
            setIsUnauthorizedNavBlockModalOpen(true);
            return;
        } 
            
        router.push(`/${mediaType}/${media!.tmdbId}`) 
    }
    
    const handleMediaClick = (e: React.MouseEvent<HTMLDivElement>) => {
        e.preventDefault();
        openMediaDetails();
    }

    // Loading
    if(!media) 
        return <MediaCardSkeletonLoader />;

    return <div className="relative w-full max-w-md aspect-[780/1170] cursor-pointer hover:opacity-80 transition">
        <Image
            src={media.posterImgUrl || ""}
            alt={media.title}
            onClick={handleMediaClick}
            fill
            className={`object-contain rounded`}
        />
    </div>
}