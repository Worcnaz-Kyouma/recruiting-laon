"use client";
import { useAppStore } from "@/providers/user-store-provider";
import { usePathname } from "next/navigation";
import React from "react";
import CustomModal from "../CustomModal";
import { handleError, successToastStyle } from "@/utils/utils";
import { toast } from "react-toastify";
import AppAPIClient from "@/utils/AppAPIClient";

export default function RemoveMediasFromMediaListModal() {
    const { closeCurrentModal, selectedMedias, clearSelectedMedias } = useAppStore(store => store);
    const pathname = usePathname();

    const mediaListId = pathname.split("/").reverse()[0];

    const removeSelectedMediasFromList = async () => {
        try {
            const body = {
                medias: selectedMedias.map(media => ({
                    id: media.id
                }))
            }
            
            await AppAPIClient.fetchAPI("media", `list/${mediaListId}/remove-medias`, "DELETE", body);
        } catch(err) {
            return handleError(err);
        }

        clearSelectedMedias();
        closeCurrentModal();

        toast.success("Mídias removidas com sucesso!", successToastStyle);
        setTimeout(() => window.location.reload(), 1000);
    };
    
    return <CustomModal className="flex flex-col gap-6 px-10">
        <h1 className="text-center text-4xl font-semibold">Atenção!</h1>
        <p className="text-center mb-4 text-md">Tem certeza que deseja remover estas mídias de sua lista?</p>
        <button className="btn-primary" onClick={removeSelectedMediasFromList}>Sim!</button>
        <button className="btn-primary" onClick={closeCurrentModal}>Não, deixa pra la.</button>
    </CustomModal>;
}