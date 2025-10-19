"use client";
import TopPopularMedias from "@/components/TopPopularMedias";
import AppError from "@/errors/AppError";
import Movie from "@/types/Movie";
import TVSerie from "@/types/TVSerie";
import AppAPIClient from "@/utils/AppAPIClient";
import { handleError } from "@/utils/utils";
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
            handleError(err);
        }
    }

    useEffect(() => {
        populateMedias();
    }, []);
    
    return <div className="flex-grow overflow-y-auto">
        <div className="flex flex-col gap-[40px] p-8 px-[90px] pb-16">
            <h1 className="main-title">Populares</h1>
            <TopPopularMedias medias={medias?.movies} />
            <TopPopularMedias medias={medias?.tvSeries} />
        </div>
    </div>;
}