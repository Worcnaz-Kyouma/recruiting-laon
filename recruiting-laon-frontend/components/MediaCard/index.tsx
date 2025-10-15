import { MediaType } from "@/enums/MediaType";
import Media from "@/types/Media";
import Image from "next/image";
import { useRouter } from "next/navigation";
import React from "react";

// TODO: Handle no poster media
export default function MediaCard({ media }: Readonly<{ media: Media | undefined }>) {
    const router = useRouter();
    const isTVSerieMedia = media && "seasons" in media;
    const mediaType = isTVSerieMedia
        ? MediaType.TVSerie
        : MediaType.Movie;

    const openMediaDetails = () => router.push(`/${mediaType}/${media!.tmdbId}`);
    
    const handleMediaClick = (e: React.MouseEvent<HTMLDivElement>) => {
        e.preventDefault();
        openMediaDetails();
    }

    // TODO: Render the loading div while url image didnt resolved the image yet
    // Loading
    if(!media) 
        return <div className="w-full max-w-md aspect-[780/1170] cursor-pointer hover:opacity-80 transition bg-gray-300 animate-pulse" />; // Skeleton loader

    return <div className="relative w-full max-w-md aspect-[780/1170] cursor-pointer hover:opacity-80 transition">
        <Image
            src={media.posterImgUrl || ""}
            alt={media.title}
            onClick={handleMediaClick}
            fill
            className="object-contain rounded"
        />
    </div>
}