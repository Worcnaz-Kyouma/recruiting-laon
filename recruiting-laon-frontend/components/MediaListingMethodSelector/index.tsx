"use client"

import { MediaType } from "@/enums/MediaType";
import AppError from "@/errors/AppError";
import ListingMethod from "@/types/ListingMethod";
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError } from "@/utils/utils";
import { useEffect, useState } from "react";
import { CaretDown } from "phosphor-react";
import CustomSelect from "../CustomSelect";

interface MediaListingMethodSelectorProps {
    mediaType: MediaType;
    listingMethod: string | undefined;
    setListingMethod: (value: string) => void;
}

export default function MediaListingMethodSelector({ mediaType, listingMethod, setListingMethod }: Readonly<MediaListingMethodSelectorProps>) {
    const [ listingMethods, setListingMethods ] = useState<ListingMethod[]>([]);

    const populateListingMethods = async () => {
        try {
            const apiResponse = await AppAPIClient.fetchAPI("media", `listing-method/${mediaType}`, "GET");

            setListingMethods(apiResponse);
            setListingMethod(apiResponse[0].value);
        } catch(err) {
            invokeToastsUsingError(err);
        }
    }
    useEffect(() => {
        populateListingMethods();
    }, []);

    return <CustomSelect options={listingMethods} value={listingMethod} setValue={setListingMethod} />
}