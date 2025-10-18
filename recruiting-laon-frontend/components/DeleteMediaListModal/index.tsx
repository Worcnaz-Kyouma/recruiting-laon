"use client";
import { useAppStore } from "@/providers/user-store-provider";
import { useRouter } from "next/navigation";
import React from "react";
import CustomModal from "../CustomModal";
import { usePathname } from "next/navigation";
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError, successToastStyle } from "@/utils/utils";
import { toast } from "react-toastify";

export default function DeleteMediaListModal() {
    const { closeCurrentModal } = useAppStore(store => store);
    const router = useRouter();
    const pathname = usePathname();

    const mediaListId = pathname.split("/").reverse()[0];

    const removeSelectedMediasFromList = async () => {
        try {
            await AppAPIClient.fetchAPI("media", `list/${mediaListId}`, "DELETE");
        } catch(err) {
            return invokeToastsUsingError(err);
        }

        closeCurrentModal();

        router.push("/my-lists");

        toast.success("Lista excluida com sucesso!", successToastStyle);
    };
    
    return <CustomModal className="flex flex-col gap-6 px-10">
        <h1 className="text-center text-4xl font-semibold">Atenção!</h1>
        <p className="text-center mb-4 text-md">Tem certeza que deseja remover estas mídias de sua lista?</p>
        <button className="btn-primary" onClick={removeSelectedMediasFromList}>Sim!</button>
        <button className="btn-primary" onClick={closeCurrentModal}>Não, deixa pra la.</button>
    </CustomModal>;
}