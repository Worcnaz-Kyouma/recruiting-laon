'use client';

import React from "react";
import ExternalRedirectsNav from "../ExternalRedirectsNav";
import { useUserStore } from "@/providers/user-store-provider";

export default function CatalogFooter() {
    const { user } = useUserStore(state => state);

    return <footer className="flex items-center justify-between p-4 px-[90px] border-t border-gray-300 bg-gray-200">
        <div className="text-white">
            <span className="text-lg">Powered by TMDB API</span> {/* Change to logo */}
        </div>
        <div className="flex items-center space-x-8 text-gray-500 text-base">
            <a href="">Início</a>
            {!user && <a href="">Entrar ou Cadastrar</a>}
            <a href="">Termos e Condições</a>
            <a href="">Política de Privacidade</a>
            <a href="">Ajuda</a>
        </div>
        <ExternalRedirectsNav />
    </footer>;
}