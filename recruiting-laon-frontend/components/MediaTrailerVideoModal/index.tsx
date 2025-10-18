"use client";
import { useAppStore } from "@/providers/user-store-provider";
import { X } from "phosphor-react";
import React from "react";

interface MediaTrailerVideoModalProps {
    videoUrl: string
}
export default function MediaTrailerVideoModal({ videoUrl }: MediaTrailerVideoModalProps) {
    const { closeCurrentModal } = useAppStore(state => state);

    return <div className="relative w-[80vw] max-w-4xl p-12 bg-gray-200 border border-gray-300 rounded-2xl">
        <span className="absolute right-4 top-4 cursor-pointer" onClick={closeCurrentModal}><X weight="bold" color="white" size={24}></X></span>
        <div className="relative w-full pb-[56.25%]">
            <iframe
                className="absolute top-0 left-0 w-full h-full rounded-2xl"
                src={videoUrl}
                title="YouTube video player"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowFullScreen
            />
        </div>
    </div>
}