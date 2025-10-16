'use client'
import AppError from "@/errors/AppError";
import { User } from "@/types/User";
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError } from "@/utils/utils";
import Image from "next/image";
import { useRouter } from "next/navigation";
import { SignOut } from "phosphor-react";
import React from "react";

export default function LoggedUserDropdown({ user }: Readonly<{ user: User }>) {
    const router = useRouter();

    const handleLogout = async () => {
        try {
            await AppAPIClient.fetchAPI("user", `logout/${user.id}`, "POST");

            localStorage.removeItem("user");
    
            window.location.reload();
        } catch (err) {
            invokeToastsUsingError(err as AppError);
        }
    }

    return <div className="relative overflow-hidden group flex cursor-pointer p-2 px-4 rounded-lg border border-gray-300 text-sm text-nowrap hover:bg-gray-300 transition" onClick={handleLogout}>
        <div className="flex space-x-2 items-center w-full transition-all duration-300 group-hover:-translate-x-[calc(100%+16px)]">
            <Image 
                src={false || "/icons/default-user-icon.svg"} 
                alt={`${user.name} Imagem`} 
                width={16} 
                height={16} 
                className="object-contain" 
            /> {/* Persist user img */}
                <span>{user.name}</span>
        </div>
        <div className="absolute left-full flex space-x-2 items-center w-[calc(100%-16px)] transition-all duration-300 group-hover:-translate-x-[calc(100%-16px)]">
            <SignOut weight="bold"/>
            <span>Sair</span>
        </div>
    </div>;
}