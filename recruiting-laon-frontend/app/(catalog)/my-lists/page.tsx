"use client"

import CustomLoader from "@/components/CustomLoader";
import CustomPagination from "@/components/CustomPagination";
import MediasContainer from "@/components/MediasContainer";
import useUser from "@/hooks/useUser";
import Media from "@/types/Media";
import APIMedia from "@/types/APIMedia"
import MediaList from "@/types/MediaList"
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError } from "@/utils/utils";
import { useEffect, useState } from "react"

interface APIMediaList {
    id: number,
    name: string,
    medias: APIMedia[]
}

export default function MyListsPage() {
    const user = useUser();
    const [ isLoading, setIsLoading ] = useState<boolean>(true);

    const [ mediaLists, setMediaLists ] = useState<MediaList[]>([]);
    const [ page, setPage ] = useState<number>(1);
    const [ numberOfPages, setNumberOfPages ] = useState<number | undefined>(undefined);

    const searchUserMediaLists = async () => {
        if(!user) return;

        setIsLoading(true);
        try {
            const apiResponse = await AppAPIClient.fetchAPI("media", `list/by-user/${user.id}`, "GET", {
                page: page
            });

            setMediaLists(apiResponse.data.map((mediaList: APIMediaList) => ({
                id: mediaList.id,
                name: mediaList.name,
                medias: mediaList.medias.map(media => ({
                    id: media.id,
                    ...media.tmdb_media
                } as Media))
            } as MediaList)));
            setNumberOfPages(apiResponse.last_page);
        } catch(err) {
            invokeToastsUsingError(err);
        }

        setIsLoading(false);
    }

    useEffect(() => {
        searchUserMediaLists();
    }, [user, page]);

    if(isLoading && mediaLists.length < 1)
        return <div className="flex-grow flex items-center justify-center">
            <CustomLoader />
        </div>

    return <div className="flex-grow overflow-y-auto">
        <div className="flex flex-col gap-[40px] p-8 px-[90px] pb-16">
            <h1 className="main-title">Minhas Listas</h1>
            {mediaLists.length < 1 
                ? <div className="w-full flex items-center justify-center mt-12"><p className="text-center text-md text-gray-500">
                    Eita! Você ainda não possui listas!<br/>Para criar uma, va a qualquer listagem no nosso catalogo e selecione uma midia!
                </p></div>
                : <div className="relative flex flex-col gap-[40px]">
                    {mediaLists.map(mediaList => <MediasContainer 
                        key={mediaList.id}
                        title={mediaList.name}
                        medias={mediaList.medias}
                        redirectUrl={`/my-lists/${mediaList.id}`}
                    />)}
                    {numberOfPages &&
                        <CustomPagination page={page} setPage={setPage} numberOfPages={numberOfPages} isLoading={isLoading} />
                    }
                    
                    {isLoading && mediaLists.length > 0 &&
                        <div className={`absolute top-0 left-0 w-full h-full rounded-md flex items-center justify-center ${numberOfPages ? "bg-gray-300/40" : ""}`}>
                            <CustomLoader color="#2B7FFF" width={120} height={120}/>
                        </div>
                    }
                </div>
            }
        </div>
    </div>;
}