"use client";
import { useAppStore } from "@/providers/user-store-provider";
import React, { useEffect, useState } from "react";
import CustomModal from "../CustomModal";
import { handleError, successToastStyle } from "@/utils/utils";
import { toast } from "react-toastify";
import AppAPIClient from "@/utils/AppAPIClient";
import CustomSelect from "../CustomSelect";
import SelectOption from "@/types/SelectOption";
import useUser from "@/hooks/useUser";
import MediaList from "@/types/MediaList";
import { usePathname } from "next/navigation";
import CustomLoader from "../CustomLoader";
import CreateMediaListModal from "../CreateMediaListModal";

export default function AddMediaToExistingListModal() {
    const user = useUser();
    const pathname = usePathname();
    const { setCurrentModal } = useAppStore(state => state);
    const [ isLoading, setIsLoading ] = useState<boolean>(true);
    const { closeCurrentModal, selectedMedias, clearSelectedMedias } = useAppStore(store => store);
    const [ mediaListsOptions, setMediaListsOptions ] = useState<SelectOption[]>([]);
    const [ mediaListId, setMediaListId ] = useState<string | undefined>(undefined);

    const addMediasToExistingList = async () => {
        try {
            const body = {
                medias: selectedMedias.map(media => ({
                    tmdb_id: media.tmdbId,
                    media_type: "seasons" in media
                        ? "tv-serie"
                        : "movie"
                }))
            }
            
            await AppAPIClient.fetchAPI("media", `list/${mediaListId}/add-medias`, "PATCH", body);
        } catch(err) {
            return handleError(err);
        }

        clearSelectedMedias();
        closeCurrentModal();

        toast.success("Mídias adicionadas a lista com sucesso!", successToastStyle); 
        if(pathname.includes("my-lists"))
            setTimeout(() => window.location.reload(), 1000);
    };

    const populateMediaListsOptions = async () => {
        if(!user) return;

        setIsLoading(true);
        
        try {
            const apiResponse = await AppAPIClient.fetchAPI("media", `list/by-user/${user.id}`, "GET");
            
            const options = apiResponse.map((mediaList: MediaList) => ({
                value: mediaList.id.toString(),
                description: mediaList.name
            } as SelectOption));
            setMediaListsOptions(options);
            if(options.length > 0)
                setMediaListId(options[0].value);
        } catch(err) {
            handleError(err);
        }
        
        setIsLoading(false);
    }

    const redirectCreateMediaList = () => setCurrentModal(<CreateMediaListModal />);
    
    useEffect(() => {
        populateMediaListsOptions();
    }, [user]);

    if(isLoading) return <CustomLoader />;

    return <CustomModal className="flex flex-col items-center gap-6 px-12">
        {mediaListsOptions.length > 0
            ? <>
                <h1 className="text-center text-4xl font-semibold">Adicionar a lista</h1>
                <CustomSelect options={mediaListsOptions} value={mediaListId} setValue={setMediaListId} className="w-full" />
                <button className="btn-primary" onClick={addMediasToExistingList}>Adicionar!</button>
            </>
            : <>
                <h1 className="text-center text-4xl font-semibold">Eita! Calma la!</h1>
                <p className="text-center mb-4 text-md">Nenhuma lista encontrada. Que tal criar a sua primeira?</p>
                <button className="btn-primary" onClick={redirectCreateMediaList}>Cadastrar nova lista</button>
            </>
        }
    </CustomModal>;
}