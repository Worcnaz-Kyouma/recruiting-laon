"use client";
import { useAppStore } from "@/providers/user-store-provider";
import { useRouter } from "next/navigation";
import { X } from "phosphor-react";
import React from "react";

export default function UnauthorizedNavBlockModal() {
    const { setIsUnauthorizedNavBlockModalOpen } = useAppStore(store => store);
    const router = useRouter();

    const redirectToLogin = () => { 
        router.push("/user/login");
        setIsUnauthorizedNavBlockModalOpen(false); 
    };
    
    return <div className="relative p-6 px-6 bg-gray-200 border border-gray-300 rounded-2xl text-white max-w-96">
        <span className="absolute right-4 top-4 cursor-pointer" onClick={() => setIsUnauthorizedNavBlockModalOpen(false)}><X weight="bold" size={24}></X></span>
        <h1 className="text-center text-4xl font-semibold mb-4">Atenção!</h1>
        <p className="text-center mb-4 text-md">Parece que você esqueceu de logar no sistema!<br/>Para acessar a todo o catalogo, você precisa ter um usuário!</p>
        <button className="btn-primary" onClick={redirectToLogin}>Cadastra/Entrar!</button>
    </div>;
}