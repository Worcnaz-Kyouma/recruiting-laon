"use client"
import MediaDetails from "@/components/MediaDetails";
import AppError from "@/errors/AppError";
import Movie from "@/types/Movie";
import TVSerie from "@/types/TVSerie";
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError } from "@/utils/utils";
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
            // TODO: Improve invokeToastsUsingError to receive generic Error
            invokeToastsUsingError(err as AppError);
        }
    }

    useEffect(() => {
        populateMovie();
    }, []);

    return <MediaDetails media={tvSerie} />;
}