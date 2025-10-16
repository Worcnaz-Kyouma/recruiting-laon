"use client";
import { MediaType } from "@/enums/MediaType";
import Media from "@/types/Media";
import React, { useState } from "react";
import MediaListingMethodSelector from "../MediaListingMethodSelector";
import { MagnifyingGlass } from "phosphor-react";
import MediaCard from "../MediaCard";
import CustomInput from "../CustomInput";

export default function MediaSearcher({ mediaType }: Readonly<{ mediaType: MediaType }>) {
    const [ medias, setMedias ] = useState<Media[]>([]);
    const [ listingMethod, setListingMethod ] = useState<string | undefined>(undefined);
    const mediaTypeMainTitle = mediaType === MediaType.TVSerie
        ? "Séries"
        : "Filmes";
    
    return <div className="flex-grow p-8 px-[90px] pb-16 flex flex-col gap-[40px]">
        <h1 className="text-2xl font-semibold text-white">{mediaTypeMainTitle}</h1>
        <div className="flex flex-col gap-5">
            <div className="flex items-center justify-between gap-4">
                <MediaListingMethodSelector mediaType={mediaType} listingMethod={listingMethod} setListingMethod={setListingMethod} />
                <CustomInput placeholder={`Título`}  className="flex-grow" />
                <button className="btn-primary w-fit h-full flex items-center gap-3 px-6 py-2">
                    <MagnifyingGlass size={32} className="mr-1"/>
                    Buscar
                </button>
            </div>
            <div>
                <div>{medias.map(media => 
                    <MediaCard key={media.tmdbId} media={media} />
                )}</div>
                <div></div>
            </div>
        </div>
    </div>;
}