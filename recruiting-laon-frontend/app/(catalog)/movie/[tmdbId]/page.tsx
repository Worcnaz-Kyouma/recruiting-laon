"use client"
import MediaDetails from "@/components/MediaDetails";
import AppError from "@/errors/AppError";
import Movie from "@/types/Movie";
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError } from "@/utils/utils";
import { use, useEffect, useState } from "react";

interface MovieDetailsProps {
    params: Promise<{
        tmdbId: string;
    }>;
}

export default function MovieDetailsPage({ params }: Readonly<MovieDetailsProps>) {
    const { tmdbId } = use(params);
    const [ movie, setMovie ] = useState<Movie | undefined>(undefined);

    const populateMovie = async () => {
        try {
            const apiResponse = await AppAPIClient.fetchAPI("movie", tmdbId, "GET");
            setMovie(apiResponse);
        } catch(err) {
            // TODO: Improve invokeToastsUsingError to receive generic Error
            invokeToastsUsingError(err);
        }
    }

    useEffect(() => {
        populateMovie();
    }, []);

    return <MediaDetails media={movie} />;
}