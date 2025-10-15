"use client";
import { useUserStore } from "@/providers/user-store-provider";
import React from "react";
import LoggedUserDropdown from "../LoggedUserDropdown";

export default function CatalogHeader() {
    const { user } = useUserStore(state => state);

    return <header className="flex items-center justify-between p-4 px-[90px] bg-gray-200 border-b border-gray-300">
        <span>Catalog</span> {/* Change to logo */}
        {user
            ? <LoggedUserDropdown user={user} />
            : <div className="flex space-x-2 items-center cursor-pointer p-2 px-4 rounded-lg border border-gray-300 text-sm text-nowrap hover:bg-gray-300 transition">
                <span>Entrar</span>
            </div>
        }
    </header>
}