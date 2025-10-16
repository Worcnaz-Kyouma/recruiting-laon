"use client";
import { MediaType } from "@/enums/MediaType";
import Media from "@/types/Media";
import React, { useEffect, useState } from "react";
import MediaListingMethodSelector from "../MediaListingMethodSelector";
import { MagnifyingGlass } from "phosphor-react";
import MediaCard from "../MediaCard";
import CustomInput from "../CustomInput";
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError } from "@/utils/utils";
import AppError from "@/errors/AppError";
import CustomLoader from "../CustomLoader";
import CustomPagination from "../CustomPagination";

// TODO: Change some components
export default function MediaSearcher({ mediaType }: Readonly<{ mediaType: MediaType }>) {
    const [ isLoading, setIsLoading ] = useState<boolean>(false);
    const [ isSearchingByTitle, setIsSearchingByTitle ] = useState<boolean>(false);

    const [ listingMethod, setListingMethod ] = useState<string | undefined>(undefined);
    const [ searchTitle, setSearchTitle ] = useState<string>("");

    const [ medias, setMedias ] = useState<Media[]>([]);
    const [ page, setPage ] = useState<number>(1);
    const [ numberOfPages, setNumberOfPages ] = useState<number | undefined>(undefined);

    const mediaTypeMainTitle = mediaType === MediaType.TVSerie
        ? "Séries"
        : "Filmes";

    useEffect(() => {
        const initialPage = 1;
        setPage(initialPage);
        
        searchMediasByListingMethod(initialPage);
    }, [ listingMethod ]);
    
    const searchMediasByListingMethod = async (searchPage?: number) => {
        if(typeof listingMethod === 'undefined') return;
        setIsLoading(true);

        setIsSearchingByTitle(false);
        setSearchTitle("");
        
        try {
            const apiResponse = await AppAPIClient.fetchAPI(mediaType, "by-listing-method", "GET", {
                listing_method: listingMethod,
                page: searchPage || page
            });

            setMedias(apiResponse.results);
            setNumberOfPages(apiResponse.numberOfPages);
        } catch(err) {
            invokeToastsUsingError(err as AppError);
        }

        setIsLoading(false);
    }

    const searchMediasByTitle = async () => {
        if(searchTitle === "") return searchMediasByListingMethod();

        setIsSearchingByTitle(true);
        setIsLoading(true);
        
        try {
            const apiResponse = await AppAPIClient.fetchAPI(mediaType, "by-title", "GET", {
                title: searchTitle,
                page: page
            });

            setMedias(apiResponse.results);
            setNumberOfPages(apiResponse.numberOfPages);
        } catch(err) {
            invokeToastsUsingError(err as AppError);
        }

        setIsLoading(false);
    }

    const onPageChange = (newPage: number) => {
        if(isSearchingByTitle) searchMediasByTitle()
        else searchMediasByListingMethod(newPage);
    }
    
    return <div className="flex-grow p-8 px-[90px] pb-16 flex flex-col gap-[40px]">
        <h1 className="text-2xl font-semibold text-white">{mediaTypeMainTitle}</h1>
        <div className="flex flex-col gap-10">
            <div className="flex items-stretch justify-between gap-4">
                <MediaListingMethodSelector mediaType={mediaType} listingMethod={listingMethod} setListingMethod={setListingMethod} />
                <div className="flex items-center justify-center">
                    <span>ou</span>
                </div>
                <CustomInput placeholder={`Título`} value={searchTitle} setValue={setSearchTitle} className="flex-grow" />
                <button className="btn-primary w-fit h-full flex items-center gap-3 px-6 py-2" onClick={searchMediasByTitle}>
                    <MagnifyingGlass size={32} className="mr-1"/>
                    Buscar
                </button>
            </div>
            <div className="relative">
                <div className="grid p-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6 bg-">{medias.map(media => 
                    <MediaCard key={media.tmdbId} media={media} />
                )}</div>
                {numberOfPages &&
                    <div className="p-2">
                        <CustomPagination page={page} setPage={setPage} numberOfPages={numberOfPages} afterChange={onPageChange} isLoading={isLoading} />
                    </div>
                }
                {isLoading &&
                    <div className={`absolute top-0 left-0 w-full h-full rounded-md flex items-center justify-center ${numberOfPages ? "bg-gray-300/40" : ""}`}>
                        <CustomLoader color="#2B7FFF" width={164} height={164}/>
                    </div>
                }
            </div>
        </div>
    </div>;
}