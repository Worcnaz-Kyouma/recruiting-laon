"use client";
import { ArrowLeft, ArrowRight } from "phosphor-react";
import React from "react";
import { ArrayOptions } from "stream";

interface ArrowButton {
    orientation: "right"|"left";
    onClick: () => void;
    label?: string;
}
export default function ArrowButton({ orientation, onClick, label }: ArrowButton) {
    const orientationToArrowIconMap = {
        right: ArrowRight,
        left: ArrowLeft
    }
     const ArrowIcon = orientationToArrowIconMap[orientation];

    return <button className="cursor-pointer flex items-center gap-4" onClick={onClick}>
        <div className="w-8 h-8 rounded-full border border-gray-500 flex items-center justify-center cursor-pointer hover:bg-gray-200 transition">
            <ArrowIcon size={16} weight="bold" className="text-white" />
        </div> 
        {label && <span className="text-action">{label}</span>}
    </button>
}