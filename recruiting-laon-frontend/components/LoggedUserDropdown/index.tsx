"use client";
import { useUserStore } from "@/providers/user-store-provider";
import { User } from "@/types/User";
import Image from "next/image";
import React from "react";

export default function LoggedUserDropdown({ user }: Readonly<{ user: User }>) {
    return <div className="flex space-x-2 items-center cursor-pointer p-2 px-4 rounded-lg border border-gray-300 text-sm text-nowrap hover:bg-gray-300 transition">
        <Image 
            src={false || "/icons/default-user-icon.svg"} 
            alt={`${user.name} Imagem`} 
            width={16} 
            height={16} 
            className="object-contain" 
        /> {/* Persist user img */}
            <span>{user.name}</span>
    </div>;
}