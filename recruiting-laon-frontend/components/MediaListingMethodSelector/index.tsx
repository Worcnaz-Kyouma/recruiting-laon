"use client"

import { MediaType } from "@/enums/MediaType";
import AppError from "@/errors/AppError";
import ListingMethod from "@/types/ListingMethod";
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError } from "@/utils/utils";
import { useEffect, useState } from "react";
import { CaretDown } from "phosphor-react";

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
            invokeToastsUsingError(err as AppError);
        }
    }
    useEffect(() => {
        populateListingMethods();
    }, []);

    const handleChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        setListingMethod(e.target.value);
    };

    if(listingMethods.length < 1) return <></>

    return <div className="relative inline-block min-w-40">
        <select
            value={listingMethod}
            onChange={handleChange}
            className="
                appearance-none w-full h-full text-white border border-gray-300 rounded-md 
                px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500
            "
        >
            {listingMethods.map((method) => (
            <option key={method.value} value={method.value} className="bg-gray-800 text-white">
                {method.description}
            </option>
            ))}
        </select>

        <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <CaretDown weight="bold" size={20}/>
        </div>
    </div>
}