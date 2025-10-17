"use client";
import { X } from "phosphor-react";
import React, { ReactNode } from "react";

interface CustomModalProps {
    children:  ReactNode;
    closeModal: () => void;
    className?: string;
}
export default function CustomModal({ children, closeModal, className = "" }: CustomModalProps) {
    return <div className={`relative p-6 px-6 bg-gray-200 border border-gray-300 rounded-2xl text-white max-w-96 ${className}`}>
        <span className="absolute right-4 top-4 cursor-pointer" onClick={closeModal}><X weight="bold" size={24}></X></span>
        {children}
    </div>;
}