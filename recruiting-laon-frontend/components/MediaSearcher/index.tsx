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
import CustomLoader from "../CustomLoader";
import CustomPagination from "../CustomPagination";
import MediaCardsGrid from "../MediaCardsGrid";
import { useAppStore } from "@/providers/user-store-provider";

export default function MediaSearcher({ mediaType }: Readonly<{ mediaType: MediaType }>) {
    const { lastMediaTitleSearched, setLastMediaTitleSearched } = useAppStore(state => state);
    const [ isLoading, setIsLoading ] = useState<boolean>(false);
    const [ isSearchingByTitle, setIsSearchingByTitle ] = useState<boolean>(lastMediaTitleSearched != '');

    const [ listingMethod, setListingMethod ] = useState<string | undefined>(undefined);
    const [ searchTitle, setSearchTitle ] = useState<string>(lastMediaTitleSearched || "");

    const [ medias, setMedias ] = useState<Media[]>([]);
    const [ page, setPage ] = useState<number>(1);
    const [ numberOfPages, setNumberOfPages ] = useState<number | undefined>(undefined);

    const mediaTypeMainTitle = mediaType === MediaType.TVSerie
        ? "Séries"
        : "Filmes";

    // Initial search by store title
    useEffect(() => {
        if(isSearchingByTitle) 
            searchMediasByTitle();
        else searchMediasByListingMethod();
    }, [])

    useEffect(() => {
        if(isSearchingByTitle) return;

        searchMediasByListingMethod(1);
    }, [ listingMethod ]);
    
    const searchMediasByListingMethod = async (searchPage?: number) => {
        if(typeof listingMethod === 'undefined') return;
        setIsLoading(true);

        setLastMediaTitleSearched("");
        setSearchTitle("");
        if(searchPage)
            setPage(searchPage);
        
        try {
            const apiResponse = await AppAPIClient.fetchAPI(mediaType, "by-listing-method", "GET", {
                listing_method: listingMethod,
                page: searchPage || page
            });

            setMedias(apiResponse.results);
            setNumberOfPages(apiResponse.numberOfPages);
        } catch(err) {
            invokeToastsUsingError(err);
        }

        setIsLoading(false);
    }

    const handleSearchMediaClick = () => searchMediasByTitle(1);

    const searchMediasByTitle = async (searchPage?: number) => {
        if(searchTitle === "") return searchMediasByListingMethod(1);

        setIsSearchingByTitle(true);
        setIsLoading(true);
        setLastMediaTitleSearched(searchTitle);
        if(searchPage)
            setPage(searchPage);
        
        try {
            const apiResponse = await AppAPIClient.fetchAPI(mediaType, "by-title", "GET", {
                title: searchTitle,
                page: searchPage || page
            });

            setMedias(apiResponse.results);
            setNumberOfPages(apiResponse.numberOfPages);
        } catch(err) {
            invokeToastsUsingError(err);
        }

        setIsLoading(false);
    }

    const onPageChange = (newPage: number) => {
        if(isSearchingByTitle) searchMediasByTitle()
        else searchMediasByListingMethod(newPage);
    }

    const handleEnter = (e: React.KeyboardEvent<HTMLInputElement>) => {
        if (e.key === "Enter") {
            e.preventDefault();
            handleSearchMediaClick();
        }
    }
    
    return <div className="flex-grow p-8 px-[90px] pb-16 flex flex-col gap-[40px]">
        <h1 className="main-title">{mediaTypeMainTitle}</h1>
        <div className="flex flex-col gap-10">
            <div className="flex items-stretch justify-between gap-4">
                <MediaListingMethodSelector mediaType={mediaType} listingMethod={listingMethod} setListingMethod={setListingMethod} unsetTitleSearch={() => setIsSearchingByTitle(false)} />
                <div className="flex items-center justify-center">
                    <span>ou</span>
                </div>
                <CustomInput placeholder={`Título`} value={searchTitle} setValue={setSearchTitle} className="flex-grow" onKeyDown={handleEnter} />
                <button className="btn-primary w-fit h-full flex items-center gap-3 px-6 py-2" onClick={handleSearchMediaClick}>
                    <MagnifyingGlass size={32} className="mr-1"/>
                    Buscar
                </button>
            </div>
            <div className="relative">
                <div className="p-2">
                    <MediaCardsGrid medias={medias} />
                </div>
                {numberOfPages &&
                    <div className="p-2">
                        <CustomPagination page={page} setPage={setPage} numberOfPages={numberOfPages} afterChange={onPageChange} isLoading={isLoading} />
                    </div>
                }
                {isLoading && medias.length > 0 &&
                    <div className={`absolute top-0 left-0 w-full h-full rounded-md flex items-center justify-center ${numberOfPages ? "bg-gray-300/40" : ""}`}>
                        <CustomLoader color="#2B7FFF" width={120} height={120}/>
                    </div>
                }
            </div>
        </div>
    </div>;
}