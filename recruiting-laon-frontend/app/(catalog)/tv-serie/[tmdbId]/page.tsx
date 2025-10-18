"use client"
import MediaDetails from "@/components/MediaDetails";
import AppError from "@/errors/AppError";
import Movie from "@/types/Movie";
import TVSerie from "@/types/TVSerie";
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError } from "@/utils/utils";
import Image from "next/image";
import { use, useEffect, useState } from "react";

interface TVSerieDetailsProps {
    params: Promise<{
        tmdbId: string;
    }>;
}

export default function TVSerieDetailsPage({ params }: Readonly<TVSerieDetailsProps>) {
    const { tmdbId } = use(params);
    const [ tvSerie, setTVSerie ] = useState<TVSerie | undefined>(undefined);

    const populateMovie = async () => {
        try {
            const apiResponse = await AppAPIClient.fetchAPI("tv-serie", tmdbId, "GET");
            setTVSerie(apiResponse);
        } catch(err) {
            invokeToastsUsingError(err);
        }
    }

    useEffect(() => {
        populateMovie();
    }, []);

    return <div className="flex flex-col w-full">
        <MediaDetails media={tvSerie} />
        {typeof tvSerie !== "undefined" && <div className="px-[90px] pt-8 pb-16">
            <h2 className="font-semibold text-xl leading-6 tracking-normal text-white border-b border-gray-300 py-2 mb-4">Temporadas</h2>
            <div className="flex gap-4 overflow-x-auto pb-2">{tvSerie?.seasons?.map(season => 
                <div key={season.tmdbId} className="flex-none relative w-[200px] aspect-[780/1170]">
                    <Image 
                        alt={`Temporada ${season.seasonNumber}`}
                        src={season.posterImgUrl || "/media-image-not-found.svg"}
                        fill
                        className="rounded"
                    />
                </div>
            )}</div>
        </div>}
        {/** cursor-pointer hover:opacity-80 transition to add modals */}
    </div>;
}