import Media from "@/types/Media";
import Image from "next/image";
import React from "react";

// TODO: Handle no poster media
export default function MediaCard({ media }: Readonly<{ media: Media | null }>) {
    const openMediaDetails = () => {}
    
    const handleMediaClick = (e: React.MouseEvent<HTMLDivElement>) => {
        e.preventDefault();
        openMediaDetails();
    }

    // Loading
    if(!media) 
        return <div className="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg h-auto object-cover rounded cursor-pointer hover:opacity-80 transition bg-gray-300 animate-pulse" />; // Skeleton loader

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

//w-48 h-72 object-cover rounded cursor-pointer hover:opacity-80 transition