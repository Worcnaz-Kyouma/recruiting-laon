"use client";
import { useAppStore } from "@/providers/user-store-provider";
import { useRouter } from "next/navigation";
import React from "react";
import CustomModal from "../CustomModal";

export default function UnauthorizedNavBlockModal() {
    const { closeCurrentModal } = useAppStore(store => store);
    const router = useRouter();

    const redirectToLogin = () => {
        router.push("/user/login");
        closeCurrentModal(); 
    };
    
    return <CustomModal closeModal={closeCurrentModal}>
        <h1 className="text-center text-4xl font-semibold mb-4">Atenção!</h1>
        <p className="text-center mb-4 text-md">Parece que você esqueceu de logar no sistema!<br/>Para acessar a todo o catalogo, você precisa ter um usuário!</p>
        <button className="btn-primary" onClick={redirectToLogin}>Cadastra/Entrar!</button>
    </CustomModal>;
}