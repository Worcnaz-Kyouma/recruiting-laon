'use client';

import React from "react";
import ExternalRedirectsNav from "../ExternalRedirectsNav";
import useUser from "@/hooks/useUser";
import Link from "next/link";
import Image from "next/image";

export default function CatalogFooter() {
    const user = useUser();

    return <footer className="flex items-center justify-between p-4 px-[90px] border-t border-gray-300 bg-gray-100">
        <div className="flex gap-3 items-center min-w-[241px]">
            <span>Powered by</span>
            <Link href="https://developer.themoviedb.org/docs/getting-started">
                <Image
                    src="/tmdb-api.svg"
                    alt="TMDB Api"
                    className=""
                    width={140}
                    height={80}
                />
            </Link>
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