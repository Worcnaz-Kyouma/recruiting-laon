"use client";
import useUser from "@/hooks/useUser";
import { useAppStore } from "@/providers/user-store-provider";
import { usePathname } from "next/navigation";
import { MinusCircle, Plus } from "phosphor-react";
import React from "react";
import UnauthorizedNavBlockModal from "../UnauthorizedNavBlockModal";
import RemoveMediasFromMediaListModal from "../RemoveMediasFromMediaListModal";
import CreateMediaListModal from "../CreateMediaListModal";
import FixedCustomButton from "../FixedCustomButton";

export default function ManageMediaListButton() {
    const user = useUser();
    const pathname = usePathname();
    const { setCurrentModal } = useAppStore(state => state);
    const isOnSomeMediaListDetails = pathname.includes("/my-lists/"); // Can remove medias from a list only when inside its details

    const handleMediaListManage = () => {
        if(!user) return setCurrentModal(<UnauthorizedNavBlockModal/>);

        setCurrentModal(isOnSomeMediaListDetails 
            ? <RemoveMediasFromMediaListModal/>
            : <CreateMediaListModal />
        );
    }

    if(isOnSomeMediaListDetails) return <FixedCustomButton 
        icon={<MinusCircle weight="bold" size={20}/>} 
        text="REMOVER DA LISTA" onClick={handleMediaListManage} 
    />
    else return <FixedCustomButton 
        icon={<Plus weight="bold" size={20}/>} 
        text="CRIAR LISTA" onClick={handleMediaListManage}
    />
}