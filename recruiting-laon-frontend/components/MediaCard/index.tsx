"use client"
import { MediaType } from "@/enums/MediaType";
import useUser from "@/hooks/useUser";
import { useAppStore } from "@/providers/user-store-provider";
import Media from "@/types/Media";
import Checkbox from "@mui/material/Checkbox";
import Image from "next/image";
import { useRouter } from "next/navigation";
import React, { useEffect, useState } from "react";

const MediaCardSkeletonLoader = () => <div className="w-full max-w-md aspect-[780/1170] rounded cursor-pointer hover:opacity-80 transition bg-gray-300 animate-pulse" />;

// TODO: IMPORTANT Handle no poster media
// TODO: Wait until image is loaded
export default function MediaCard({ media }: Readonly<{ media: Media | undefined }>) {
    const router = useRouter();
    const user = useUser();
    const { selectedMedias, setIsUnauthorizedNavBlockModalOpen, addMediaIntoSelectedMedias, removeMediaFromSelectedMedias } = useAppStore(state => state);
    
    const [ isSelected , setIsSelected] = useState<boolean>(false);
    const [ isHover, setIsHover ] = useState<boolean>(false);

    const isTVSerieMedia = media && "seasons" in media;

    const mediaType = isTVSerieMedia
        ? MediaType.TVSerie
        : MediaType.Movie;

    const handleMediaSelection = (e: React.ChangeEvent<HTMLInputElement>) => {
        const isSelectingMedia = e.target.checked;
        setIsSelected(isSelectingMedia);
        
        if(isSelectingMedia) addMediaIntoSelectedMedias(media!);
        else removeMediaFromSelectedMedias(media!);
    }

    const openMediaDetails = () => {
        if(!user) return setIsUnauthorizedNavBlockModalOpen(true);
            
        router.push(`/${mediaType}/${media!.tmdbId}`) 
    }

    useEffect(() => {
        if(selectedMedias.length < 1)
            setIsSelected(false)
    }, [ selectedMedias ])
    
    const handleMediaClick = (e: React.MouseEvent<HTMLDivElement>) => {
        e.preventDefault();
        openMediaDetails();
    }

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
            src={media.posterImgUrl || ""}
            alt={media.title}
            onClick={handleMediaClick}
            fill
            className={`rounded`}
        />
    </div>
}