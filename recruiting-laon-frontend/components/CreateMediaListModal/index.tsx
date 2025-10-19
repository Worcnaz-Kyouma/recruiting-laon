"use client";
import { useAppStore } from "@/providers/user-store-provider";
import { useRouter } from "next/navigation";
import React, { useState } from "react";
import CustomModal from "../CustomModal";
import CustomInput from "../CustomInput";
import AppAPIClient from "@/utils/AppAPIClient";
import useUser from "@/hooks/useUser";
import { handleError, successToastStyle } from "@/utils/utils";
import { toast } from "react-toastify";

export default function CreateMediaListModal() {
    const { closeCurrentModal, selectedMedias, clearSelectedMedias } = useAppStore(store => store);
    const user = useUser();
    const [ name, setName ] = useState<string>("");

    const createMediaList = async () => {
        try {
            const body = {
                user_id: user!.id,
                name: name,
                medias: selectedMedias.map(media => ({
                    tmdb_id: media.tmdbId,
                    media_type: "seasons" in media
                        ? "tv-serie"
                        : "movie"
                }))
            }
            
            await AppAPIClient.fetchAPI("media", `list`, "POST", body);
        } catch(err) {
            return handleError(err);
        }

        clearSelectedMedias();
        closeCurrentModal();

        toast.success("Lista criada com sucesso!", successToastStyle); 
    };
    
    return <CustomModal className="flex flex-col gap-6 px-10">
        <h1 className="text-center text-4xl font-semibold">Nova Lista</h1>
        <CustomInput placeholder="Nome" value={name} setValue={setName} />
        <button className="btn-primary" onClick={createMediaList}>Criar!</button>
    </CustomModal>;
}