"use client"
import { usePathname, useRouter } from "next/navigation";
import { ArrowLeft } from "phosphor-react";
import React from "react";

// TODO: Wrap arrow buttons and spaced strings into components somehow
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
            <button className="cursor-pointer flex items-center gap-4" onClick={handleHomePageRedirect}>
                <div className="w-8 h-8 rounded-full border border-gray-500 flex items-center justify-center cursor-pointer hover:bg-gray-200 transition">
                    <ArrowLeft size={16} weight="bold" className="text-white" />
                </div>
                <span className="cursor-pointer text-base font-medium tracking-widest">VOLTAR</span>
            </button>
        </div>
        <span>Catalog</span> {/* Change to logo */}
        <div className="min-w-[150px] text-right">
            <span className="cursor-pointer text-base font-medium tracking-widest" onClick={handleRegisterOrLoginRedirect}>{isLogin
                ? "CADASTRAR"
                : "ENTRAR"
            }</span>
        </div>
    </header>
}