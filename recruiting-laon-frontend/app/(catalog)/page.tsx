"use client";
import TopPopularMedias from "@/components/TopPopularMedias";
import { MediaType } from "@/enums/MediaType";
import AppError from "@/errors/AppError";
import Media from "@/types/Media";
import Movie from "@/types/Movie";
import TVSerie from "@/types/TVSerie";
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError } from "@/utils/utils";
import { useEffect, useState } from "react";

type MediaTopPopularDTO = {
    movies: Movie[],
    tvSeries: TVSerie[]
}

export default function HomePage() {
    const [ medias, setMedias ] = useState<MediaTopPopularDTO | undefined>(undefined);

    const populateMedias = async () => {
        try {
            const apiResponse = await AppAPIClient.fetchAPI("media", "top-popular", "GET");
            setMedias(apiResponse);
        } catch(err) {
            invokeToastsUsingError(err as AppError);
        }
    }

    useEffect(() => {
        populateMedias();
    }, []);
    
    return <div className="flex-grow overflow-y-auto">
        <div className="flex flex-col gap-[40px] p-8 px-[90px] pb-16">
            <h1 className="text-2xl font-semibold text-white">Populares</h1>
            <TopPopularMedias medias={medias?.movies} />
            <TopPopularMedias medias={medias?.tvSeries} />
        </div>
    </div>;
}