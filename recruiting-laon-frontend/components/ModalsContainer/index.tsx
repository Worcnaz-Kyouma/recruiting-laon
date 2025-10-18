"use client";
import React from "react";
import { useAppStore } from "@/providers/user-store-provider";

// TODO: IMPORTANT modal to add into media list
export default function ModalsContainer() {
    const { 
        currentModal
    } = useAppStore(store => store);

    // TODO: Enable it?
    // useEffect(() => {
    //     if (typeof currentModal !== 'undefined') {
    //         document.body.classList.add("overflow-hidden");
    //     } else {
    //         document.body.classList.remove("overflow-hidden");
    //     }

    //     return () => document.body.classList.remove("overflow-hidden");
    // }, [ currentModal ]);

    if(typeof currentModal === 'undefined') return <></>

    return <div className="w-full h-full fixed top-0 left-0 z-100 flex items-center justify-center bg-gray-100/40">
        {currentModal}
    </div>;
}