"use client";
import React from "react";
import LoggedUserDropdown from "../LoggedUserDropdown";
import Link from "next/link";
import { usePathname, useRouter } from "next/navigation";
import useUser from "@/hooks/useUser";
import ArrowButton from "../ArrowButton";
import { useRouterHistory } from "@/hooks/useRouterHistory";

export default function CatalogHeader() {
    const router = useRouter();
    const user = useUser();
    const routerHistory = useRouterHistory();

    const pathname = usePathname();
    const isHome = pathname === "/";

    const handleHomePageRedirect = () => {
        if(!["/movie", "/tv-serie", "/my-lists"].includes(pathname))
            router.push(routerHistory.length > 2 
                ? routerHistory[routerHistory.length - 2] 
                : "/"
            ); 
        else router.push("/");
    };

    return <header className="flex items-center justify-between p-6 px-[90px] bg-gray-200 border-b border-gray-300">
        {isHome 
            ? <span>Catalog</span>
            : <ArrowButton orientation="left" onClick={handleHomePageRedirect} label="VOLTAR" />
        }
        {user
            ? <div className="flex items-center gap-8">
                <Link href={"/my-lists"}>
                    <span className="text-action">
                        MINHAS LISTAS
                    </span>
                </Link>
                <LoggedUserDropdown user={user} />
            </div>
            : <Link href={"/user/login"}>
                <span className="text-action">
                    ENTRAR
                </span>
            </Link>
        }
    </header>
}