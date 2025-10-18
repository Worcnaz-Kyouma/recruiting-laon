"use client";
import { useAppStore } from "@/providers/user-store-provider";
import { usePathname } from "next/navigation";
import React from "react";
import CustomModal from "../CustomModal";
import { invokeToastsUsingError, successToastStyle } from "@/utils/utils";
import { toast } from "react-toastify";
import AppAPIClient from "@/utils/AppAPIClient";

// TODO: IMPORTANT make an endpoint to remove a buck of medias, not only one per one
export default function RemoveMediasFromMediaListModal() {
    const { closeCurrentModal, selectedMedias, clearSelectedMedias } = useAppStore(store => store);
    const pathname = usePathname();

    const mediaListId = pathname.split("/").reverse()[0];

    const removeSelectedMediasFromList = async () => {
        try {
            const removingMedias = selectedMedias.map(media => 
                AppAPIClient.fetchAPI("media", `list/${mediaListId}/${media.id}`, "DELETE")
            );
            await Promise.all(removingMedias);
        } catch(err) {
            invokeToastsUsingError(err);
        }

        clearSelectedMedias();
        closeCurrentModal();

        toast.success("Mídias removidas com sucesso!", successToastStyle);
        setTimeout(() => window.location.reload(), 1000);
    };
    
    return <CustomModal className="flex flex-col gap-6 px-10" closeModal={closeCurrentModal}>
        <h1 className="text-center text-4xl font-semibold">Atenção!</h1>
        <p className="text-center mb-4 text-md">Tem certeza que deseja remover estas mídias de sua lista?</p>
        <button className="btn-primary" onClick={removeSelectedMediasFromList}>Sim!</button>
        <button className="btn-primary" onClick={closeCurrentModal}>Não, deixa pra la.</button>
    </CustomModal>;
}