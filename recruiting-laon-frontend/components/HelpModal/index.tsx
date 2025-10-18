"use client";
import React from "react";
import InfoModal from "../InfoModal";

export default function HelpModal() {
    return <InfoModal title="Ajuda" info={`
        O que? Você precisa de ajuda pra escolher um filme ou usar o sistema? XD
        
        Para usar este sistema, recomendamos que você tenha uma conta! 
        Cadastre uma clicando em "ENTRAR" no cabeçalho.

        Depois dai, é so felicidade.
        Você pode criar listas de mídias, ver seus detalhes(se houver informações em Português, o catalogo as mostrará tambem!).

        Bom uso! Espero que goste, deu um pouco de trabalho! XD
        Obrigado pela oportunidade!
    `} />;
}