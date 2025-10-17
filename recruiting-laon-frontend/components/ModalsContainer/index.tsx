"use client";
import React, { useEffect, useState } from "react";
import UnauthorizedNavBlockModal from "../UnauthorizedNavBlockModal";
import { useAppStore } from "@/providers/user-store-provider";
import CreateMediaListModal from "../CreateMediaListModal";
import RemoveMediasFromMediaListModal from "../RemoveMediasFromMediaListModal";

// TODO: IMPORTANT modal to add into media list
export default function ModalsContainer() {
    const { 
        isUnauthorizedNavBlockModalOpen ,
        isCreateMediaListModalOpen,
        isRemoveMediasFromMediaListModalOpen
    } = useAppStore(store => store);
    const isAnyModalOpen = 
        isUnauthorizedNavBlockModalOpen || 
        isCreateMediaListModalOpen || 
        isRemoveMediasFromMediaListModalOpen;

    useEffect(() => {
        if (isAnyModalOpen) {
            document.body.classList.add("overflow-hidden");
        } else {
            document.body.classList.remove("overflow-hidden");
        }

        return () => document.body.classList.remove("overflow-hidden");
    }, [ isAnyModalOpen ]);

    if(!isAnyModalOpen) return <></>

    return <div className="w-full h-full fixed top-0 left-0 z-100 flex items-center justify-center bg-gray-100/40">
        {isUnauthorizedNavBlockModalOpen && <UnauthorizedNavBlockModal />}
        {isCreateMediaListModalOpen && <CreateMediaListModal />}
        {isRemoveMediasFromMediaListModalOpen && <RemoveMediasFromMediaListModal />}
    </div>;
}