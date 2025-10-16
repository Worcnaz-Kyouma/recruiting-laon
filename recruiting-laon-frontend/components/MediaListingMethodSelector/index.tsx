"use client"
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { MediaType } from "@/enums/MediaType";
import AppError from "@/errors/AppError";
import ListingMethod from "@/types/ListingMethod";
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError } from "@/utils/utils";
import { ChevronDown } from "lucide-react";
import { CaretDown } from "phosphor-react";
import { useEffect, useState } from "react";

interface MediaListingMethodSelectorProps {
    mediaType: MediaType;
    listingMethod: string | undefined;
    setListingMethod: (value: string) => void;
}

// TODO: FIX SELECT OPTIONS BREAK SCREEN
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

    if(listingMethods.length < 1) return <></>

    return (
        <Select value={listingMethod} onValueChange={setListingMethod}>
            <SelectTrigger className="min-w-40 !h-full text-md px-4 py-2 flex items-center justify-between text-white border border-gray-300 rounded-xl ![&_svg]:text-white">
                <SelectValue placeholder="Teste" />
            </SelectTrigger>
            <SelectContent className="bg-gray-200 text-white border border-gray-400">
                {listingMethods.map(lMethod => 
                    <SelectItem key={lMethod.value} value={lMethod.value}>{lMethod.description}</SelectItem>)
                }
            </SelectContent>
        </Select>
    );
}