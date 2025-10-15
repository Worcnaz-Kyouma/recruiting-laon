"use client";
import { useUserStore } from "@/providers/user-store-provider";
import React from "react";
import LoggedUserDropdown from "../LoggedUserDropdown";

export default function CatalogHeader() {
    const { user } = useUserStore(state => state);

    return <header className="flex items-center justify-between p-6 px-[90px] bg-gray-200 border-b border-gray-300">
        <span>Catalog</span> {/* Change to logo */}
        {user
            ? <LoggedUserDropdown user={user} />
            : <button className="cursor-pointer text-base font-medium tracking-widest">ENTRAR</button>
        }
    </header>
}