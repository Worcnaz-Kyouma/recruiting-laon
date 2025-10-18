"use client";
import { useAppStore } from "@/providers/user-store-provider";
import React from "react";
import UnauthorizedNavBlockModal from "../UnauthorizedNavBlockModal";
import { PlusCircle } from "phosphor-react";
import useUser from "@/hooks/useUser";
import { usePathname } from "next/navigation";
import AddMediaToExistingListModal from "../AddMediaToExistingListModal";
import FixedCustomButton from "../FixedCustomButton";

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

    return <FixedCustomButton icon={<PlusCircle weight="bold" size={20}/>} text="ADICIONAR A LISTA" onClick={handleAddMediaToExistingList} />
}