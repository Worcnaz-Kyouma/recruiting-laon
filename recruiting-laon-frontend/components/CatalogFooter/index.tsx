'use client';

import React from "react";
import ExternalRedirectsNav from "../ExternalRedirectsNav";
import useUser from "@/hooks/useUser";
import Link from "next/link";

export default function CatalogFooter() {
    const user = useUser();

    return <footer className="flex items-center justify-between p-4 px-[90px] border-t border-gray-300 bg-gray-200">
        <div className="text-white">
            <span className="text-lg">Powered by TMDB API</span> {/* Change to logo */}
        </div>
        <div className="flex items-center space-x-8 text-gray-500 text-sm">
            <Link href="/">Início</Link>
            {!user && <Link href="/user/register">Entrar ou Cadastrar</Link>}
            <a href="">Termos e Condições</a>
            <a href="">Política de Privacidade</a>
            <a href="">Ajuda</a>
        </div>
        <ExternalRedirectsNav />
    </footer>;
}