"use client";
import React, { JSX } from "react";

interface FixedCustomButtonProps {
    icon: JSX.Element,
    text: string,
    onClick: () => void
}
export default function FixedCustomButton({ icon, text, onClick }: FixedCustomButtonProps) {
    return <button className="cursor-pointer flex items-center gap-4 bg-gray-100 border border-gray-300 hover:bg-gray-200 transition text-white p-4 rounded shadow-lg" onClick={onClick}>
        {icon}
        <span className="text-action">{text}</span>
    </button>;
}