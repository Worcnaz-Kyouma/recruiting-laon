"use client";
import useUser from "@/hooks/useUser";
import { useAppStore } from "@/providers/user-store-provider";
import { usePathname } from "next/navigation";
import { MinusCircle, PlusCircle } from "phosphor-react";
import React from "react";

export default function ManageMediaListButton() {
    const user = useUser();
    const pathname = usePathname();
    const { 
        setIsUnauthorizedNavBlockModalOpen,
        isCreateMediaListModalOpen, setIsCreateMediaListModalOpen,
        isRemoveMediasFromMediaListModalOpen, setIsRemoveMediasFromMediaListModalOpen
    } = useAppStore(state => state);
    const isOnSomeMediaListDetails = pathname.includes("/my-lists/"); // Can remove medias from a list only when inside its details

    const handleMediaListManage = () => {
        if(!user) return setIsUnauthorizedNavBlockModalOpen(true);
        if(isCreateMediaListModalOpen || isRemoveMediasFromMediaListModalOpen) return;

        if(isOnSomeMediaListDetails) setIsRemoveMediasFromMediaListModalOpen(true);
        else setIsCreateMediaListModalOpen(true);
    }

    return <button className="fixed cursor-pointer flex items-center gap-4 bottom-8 right-12 bg-gray-100 border border-gray-300 hover:bg-gray-200 transition text-white p-4 rounded shadow-lg" onClick={handleMediaListManage}>
        {isOnSomeMediaListDetails
            ? <>
                <MinusCircle weight="bold" size={20}/>
                <span className="text-action">REMOVER DA LISTA</span>
            </>
            : <>
                <PlusCircle weight="bold" size={20}/>
                <span className="text-action">CRIAR LISTA</span>
            </>
        }
    </button>;
}