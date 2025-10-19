'use client'
import AppError from "@/errors/AppError";
import { User } from "@/types/User";
import AppAPIClient from "@/utils/AppAPIClient";
import { handleError } from "@/utils/utils";
import Image from "next/image";
import { SignOut } from "phosphor-react";
import React from "react";

export default function LogoutUserButton({ user }: Readonly<{ user: User }>) {
    const handleLogout = async () => {
        try {
            localStorage.removeItem("user");
            
            await AppAPIClient.fetchAPI("user", `logout/${user.id}`, "POST");

            window.location.reload();
        } catch (err) {
            if(err instanceof AppError && err.status === 401)
                return;

            handleError(err);
        }
    }

    return <div className="relative min-w-24 overflow-hidden group flex cursor-pointer p-2 px-4 rounded-lg border border-gray-300 text-sm text-nowrap hover:bg-gray-300 transition" onClick={handleLogout}>
        <div className="flex space-x-2 items-center justify-center w-full transition-all duration-300 group-hover:-translate-x-[calc(100%+16px)]">
            <Image 
                src={false || "/icons/default-user-icon.svg"} 
                alt={`${user.name} Imagem`} 
                width={16} 
                height={16} 
                className="object-contain" 
            /> {/* Persist user img */}
                <span>{user.name}</span>
        </div>
        <div className="absolute left-full flex space-x-2 items-center justify-center w-[calc(100%)] transition-all duration-300 group-hover:-translate-x-[calc(100%)]">
            <SignOut weight="bold"/>
            <span>Sair</span>
        </div>
    </div>;
}