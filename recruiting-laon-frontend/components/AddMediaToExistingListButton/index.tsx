"use client";
import { useAppStore } from "@/providers/user-store-provider";
import React from "react";
import UnauthorizedNavBlockModal from "../UnauthorizedNavBlockModal";
import { PlusCircle } from "phosphor-react";
import useUser from "@/hooks/useUser";
import { usePathname } from "next/navigation";
import AddMediaToExistingListModal from "../AddMediaToExistingListModal";

export default function AddMediaToExistingListButton() {
    const user = useUser();
    const pathname = usePathname();
    const { setCurrentModal } = useAppStore(state => state);
    const isOnSomeMediaListDetails = pathname.includes("/my-lists/"); // Can remove medias from a list only when inside its details

    const handleAddMediaToExistingList = () => {
        if(!user) return setCurrentModal(<UnauthorizedNavBlockModal/>);

        setCurrentModal(<AddMediaToExistingListModal />);
    }

    if(isOnSomeMediaListDetails) return <></>;

    return <button className="cursor-pointer flex items-center gap-4 bg-gray-100 border border-gray-300 hover:bg-gray-200 transition text-white p-4 rounded shadow-lg" onClick={handleAddMediaToExistingList}>
        <PlusCircle weight="bold" size={20}/>
        <span className="text-action">ADICIONAR A LISTA</span>
    </button>;
}