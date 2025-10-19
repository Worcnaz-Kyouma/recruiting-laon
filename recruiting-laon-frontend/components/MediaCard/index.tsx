"use client"
import { MediaType } from "@/enums/MediaType";
import useUser from "@/hooks/useUser";
import { useAppStore } from "@/providers/user-store-provider";
import Media from "@/types/Media";
import Checkbox from "@mui/material/Checkbox";
import Image from "next/image";
import { useRouter } from "next/navigation";
import React, { useEffect, useState } from "react";
import UnauthorizedNavBlockModal from "../UnauthorizedNavBlockModal";

const MediaCardSkeletonLoader = () => <div className="w-full max-w-md aspect-[780/1170] rounded cursor-pointer hover:opacity-80 transition bg-gray-300 animate-pulse" />;

export default function MediaCard({ media }: Readonly<{ media: Media | undefined }>) {
    const router = useRouter();
    const user = useUser();
    const { selectedMedias, setCurrentModal, addMediaIntoSelectedMedias, removeMediaFromSelectedMedias } = useAppStore(state => state);
    const [ isSelected, setIsSelected ] = useState<boolean>(false);
    const [ isImageLoaded, setIsImageLoaded ] = useState<boolean>(false);

    // OBS To Code Reviewer: In the last versions of NextJS, for some reason, it dont accept public routes in the blurDataUrl. So you need to put it on a base64 to work
    const blurImgBase64 = "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNzgwIiBoZWlnaHQ9IjEyNDAiIHZpZXdCb3g9IjAgMCA3ODAgMTI0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4NCjxyZWN0IHdpZHRoPSI3ODAiIGhlaWdodD0iMTI0MCIgcng9IjgiIGZpbGw9IiM0ODQ2NUIiLz4NCjwvc3ZnPg0K";
    
    const [ isHover, setIsHover ] = useState<boolean>(false);

    const isTVSerieMedia = media && "seasons" in media;

    const mediaType = isTVSerieMedia
        ? MediaType.TVSerie
        : MediaType.Movie;

    const handleMediaSelection = (e: React.ChangeEvent<HTMLInputElement>) => {
        if(!isSelected) addMediaIntoSelectedMedias(media!);
        else removeMediaFromSelectedMedias(media!);
    }

    const openMediaDetails = () => {
        if(!user) return setCurrentModal(<UnauthorizedNavBlockModal />);
            
        router.push(`/${mediaType}/${media!.tmdbId}`) 
    }
    
    const handleMediaClick = (e: React.MouseEvent<HTMLDivElement>) => {
        e.preventDefault();
        openMediaDetails();
    }

    useEffect(
        () => media && setIsSelected(selectedMedias.some(m => m.tmdbId === media.tmdbId)), 
        [selectedMedias, media]
    )

    // Loading
    if(!media) 
        return <MediaCardSkeletonLoader />;

    return <div className="relative w-full max-w-md aspect-[780/1170] cursor-pointer hover:opacity-80 transition" onMouseEnter={() => setIsHover(true)} onMouseLeave={() => setIsHover(false)}>
        {(isHover || isSelected) && <div className="absolute w-full h-1/3 bg-gradient-to-b from-gray-100 via-gray-100/80 to-transparent z-100 text-end pointer-events-none">
            <Checkbox className="pointer-events-auto" checked={isSelected} onChange={handleMediaSelection} sx={{
                color: "#9895B4",
                "&.Mui-checked": {
                    color: "white"
                }
            }} />
        </div>}
        <Image
            src={media.posterImgUrl || "/media-image-not-found.svg"}
            alt={media.title}
            onClick={handleMediaClick}
            fill
            placeholder="blur"
            blurDataURL={blurImgBase64}
            onLoad={() => setIsImageLoaded(true)}
            className={`rounded ${!isImageLoaded ? "animate-pulse" : ""}`}
        />
    </div>
}