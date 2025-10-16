"use client";
import React from "react";
import LoggedUserDropdown from "../LoggedUserDropdown";
import Link from "next/link";
import { usePathname, useRouter } from "next/navigation";
import useUser from "@/hooks/useUser";
import ArrowButton from "../ArrowButton";

// TODO: Return should go back to movies, tv-series or home-page. Store previus page.
export default function CatalogHeader() {
    const router = useRouter();
    const user = useUser();

    const pathname = usePathname();
    const isHome = pathname === "/";

    const handleHomePageRedirect = () => router.push("/");

    return <header className="flex items-center justify-between p-6 px-[90px] bg-gray-200 border-b border-gray-300">
        {isHome 
            ? <span>Catalog</span>
            : <ArrowButton orientation="left" onClick={handleHomePageRedirect} label="VOLTAR" />
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