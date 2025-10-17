"use client";
import useUser from "@/hooks/useUser";
import { useAppStore } from "@/providers/user-store-provider";
import Media from "@/types/Media";
import { useRouter } from "next/navigation";
import React from "react";
import ArrowButton from "../ArrowButton";
import MediaCardsGrid from "../MediaCardsGrid";

interface MediasContainerProps {
    title: string;
    medias: (Media | undefined)[];
    redirectUrl: string;
}

export default function MediasContainer({ title, medias, redirectUrl }: MediasContainerProps) {  
    const router = useRouter();
    const user = useUser();
    const { setIsUnauthorizedNavBlockModalOpen } = useAppStore(state => state);   
    
    const handleOpenMediaSearcher = () => {
        if(!user) return setIsUnauthorizedNavBlockModalOpen(true);

        router.push(redirectUrl);
    }

    return <div className="flex flex-col gap-3">
        <div className="flex items-center justify-between">
            <h2 className="text-sm font-semibold text-gray-500">{title}</h2>
            <ArrowButton orientation="right" onClick={handleOpenMediaSearcher} />
        </div>
        <MediaCardsGrid medias={medias}/>
    </div>;
}