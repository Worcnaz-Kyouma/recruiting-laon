"use client";
import React, { useEffect, useState } from "react";
import UnauthorizedNavBlockModal from "../UnauthorizedNavBlockModal";
import { useAppStore } from "@/providers/user-store-provider";

export default function ModalsContainer() {
    const { isUnauthorizedNavBlockModalOpen } = useAppStore(store => store);
    const isAnyModalOpen = isUnauthorizedNavBlockModalOpen;

    useEffect(() => {
        if (isUnauthorizedNavBlockModalOpen) {
            document.body.classList.add("overflow-hidden");
        } else {
            document.body.classList.remove("overflow-hidden");
        }

        return () => document.body.classList.remove("overflow-hidden");
    }, [ isUnauthorizedNavBlockModalOpen ]);

    if(!isAnyModalOpen) return <></>

    return <div className="w-full h-full absolute top-0 left-0 z-100 flex items-center justify-center bg-gray-100/40">
        {isUnauthorizedNavBlockModalOpen && <UnauthorizedNavBlockModal />}
    </div>;
}