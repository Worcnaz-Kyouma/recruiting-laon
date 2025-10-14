"use client";
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
        return <div className="w-32 h-48 bg-gray-300 animate-pulse" />; // Skeleton loader

    return <Image
        src={media.posterImgUrl || ""}
        alt={media.title}
        onClick={handleMediaClick}
    />;
}