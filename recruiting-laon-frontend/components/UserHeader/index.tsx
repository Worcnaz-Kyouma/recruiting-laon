"use client"
import { usePathname, useRouter } from "next/navigation";
import React from "react";
import ArrowButton from "../ArrowButton";

// TODO: Wrap arrow buttons and spaced strings into components somehow
// TODO: Logout
export default function UserHeader() {
    const router = useRouter();

    const pathname = usePathname();
    const isLogin = pathname.includes("/login");
    
    const handleHomePageRedirect = () => router.push("/");
    const handleRegisterOrLoginRedirect = () => isLogin 
        ? router.push("/user/register")
        : router.push("/user/login");

    return <header className="flex items-center justify-between p-6 px-[90px] border-b border-gray-300">
        <div className="min-w-[150px] text-left">
            <ArrowButton orientation="left" onClick={handleHomePageRedirect} label="VOLTAR" />
        </div>
        <span>Catalog</span> {/* Change to logo */}
        <div className="min-w-[150px] text-right">
            <span className="text-action" onClick={handleRegisterOrLoginRedirect}>{isLogin
                ? "CADASTRAR"
                : "ENTRAR"
            }</span>
        </div>
    </header>
}