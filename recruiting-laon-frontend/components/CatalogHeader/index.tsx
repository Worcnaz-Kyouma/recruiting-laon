"use client";
import React, { useEffect, useState } from "react";
import LoggedUserDropdown from "../LoggedUserDropdown";
import Link from "next/link";
import { usePathname, useRouter } from "next/navigation";
import { ArrowLeft } from "phosphor-react";
import { extractUserFromLocalStorage } from "@/utils/utils";
import { User } from "@/types/User";
import useUser from "@/hooks/useUser";

export default function CatalogHeader() {
    const router = useRouter();
    const user = useUser();

    const pathname = usePathname();
    const isHome = pathname === "/";

    const handleHomePageRedirect = () => router.push("/");

    return <header className="flex items-center justify-between p-6 px-[90px] bg-gray-200 border-b border-gray-300">
        {isHome 
            ? <span>Catalog</span>
            : <button className="cursor-pointer flex items-center gap-4" onClick={handleHomePageRedirect}>
                <div className="w-8 h-8 rounded-full border border-gray-500 flex items-center justify-center cursor-pointer hover:bg-gray-200 transition">
                    <ArrowLeft size={16} weight="bold" className="text-white" />
                </div>
                <span className="cursor-pointer text-base font-medium tracking-widest">VOLTAR</span>
            </button>
        }
        {user
            ? <LoggedUserDropdown user={user} />
            : <Link href={"/user/login"}>
                <button className="cursor-pointer text-base font-medium tracking-widest">
                    ENTRAR
                </button>
            </Link>
        }
    </header>
}