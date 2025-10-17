"use client"

import CustomLoader from "@/components/CustomLoader";
import CustomPagination from "@/components/CustomPagination";
import MediaCardsGrid from "@/components/MediaCardsGrid";
import MediasContainer from "@/components/MediasContainer";
import useUser from "@/hooks/useUser";
import Media from "@/types/Media";
import MediaList from "@/types/MediaList"
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError } from "@/utils/utils";
import { use, useEffect, useState } from "react"

interface APIMedia {
    id: number,
    tmdb_media: Media
}
interface APIMediaList {
    id: number,
    name: string,
    medias: APIMedia[]
}
interface ListDetailsPageProps {
    params: Promise<{
        mediaListId: string;
    }>;
}
export default function ListDetailsPage({ params }: Readonly<ListDetailsPageProps>) {
    const { mediaListId } = use(params);
    const user = useUser();
    const [ isLoading, setIsLoading ] = useState<boolean>(true);

    const [ mediaList, setMediaList ] = useState<MediaList | undefined>(undefined);
    const [ medias, setMedias ] = useState<Media[]>([]);
    const [ page, setPage ] = useState<number>(1);
    const [ numberOfPages, setNumberOfPages ] = useState<number | undefined>(undefined);

    const searchUserMediaListDetails = async () => {
        if(!user) return;

        setIsLoading(true);
        try {
            const apiResponse = await AppAPIClient.fetchAPI("media", `list/${mediaListId}`, "GET", {
                page: page
            });

            setMediaList(apiResponse.mediaList);
            setMedias(apiResponse.medias.data.map((media: APIMedia) => ({
                id: media.id,
                ...media.tmdb_media
            } as Media)));
            setNumberOfPages(apiResponse.medias.last_page);
        } catch(err) {
            invokeToastsUsingError(err);
        }

        setIsLoading(false);
    }

    useEffect(() => {
        searchUserMediaListDetails();
    }, [user, page]);

    if(isLoading && (typeof mediaList === "undefined" || medias.length < 1))
        return <div className="flex-grow flex items-center justify-center">
            <CustomLoader />
        </div>

    if(typeof mediaList === "undefined" || medias.length < 1)
        return <></>

    return <div className="flex-grow overflow-y-auto">
        <div className="flex flex-col gap-[40px] p-8 px-[90px] pb-16">
            <h1 className="text-2xl font-semibold text-white">{mediaList!.name}</h1>
            <div className="relative flex flex-col gap-[40px]">
                <MediaCardsGrid medias={medias} />
                {numberOfPages &&
                    <CustomPagination page={page} setPage={setPage} numberOfPages={numberOfPages} isLoading={isLoading} />
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