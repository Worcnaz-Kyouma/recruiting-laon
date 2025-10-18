"use client";
import React from "react";
import { useAppStore } from "@/providers/user-store-provider";

export default function ModalsContainer() {
    const { 
        currentModal
    } = useAppStore(store => store);

    if(typeof currentModal === 'undefined') return <></>

    return <div className="w-full h-full fixed top-0 left-0 z-100 flex items-center justify-center bg-gray-100/40">
        {currentModal}
    </div>;
}