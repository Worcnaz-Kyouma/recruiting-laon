"use client"

import { MediaType } from "@/enums/MediaType";
import AppError from "@/errors/AppError";
import ListingMethod from "@/types/ListingMethod";
import AppAPIClient from "@/utils/AppAPIClient";
import { handleError } from "@/utils/utils";
import { useEffect, useState } from "react";
import { CaretDown } from "phosphor-react";
import CustomSelect from "../CustomSelect";

interface MediaListingMethodSelectorProps {
    mediaType: MediaType;
    listingMethod: string | undefined;
    unsetTitleSearch: () => void;
    setListingMethod: (value: string) => void;
}

export default function MediaListingMethodSelector({ mediaType, listingMethod, setListingMethod, unsetTitleSearch }: Readonly<MediaListingMethodSelectorProps>) {
    const [ listingMethods, setListingMethods ] = useState<ListingMethod[]>([]);

    const populateListingMethods = async () => {
        try {
            const apiResponse = await AppAPIClient.fetchAPI("media", `listing-method/${mediaType}`, "GET");

            setListingMethods(apiResponse);
            setListingMethod(apiResponse[0].value);
        } catch(err) {
            handleError(err);
        }
    }
    useEffect(() => {
        populateListingMethods();
    }, []);

    return <CustomSelect options={listingMethods} value={listingMethod} setValue={setListingMethod} onChange={unsetTitleSearch} />
}