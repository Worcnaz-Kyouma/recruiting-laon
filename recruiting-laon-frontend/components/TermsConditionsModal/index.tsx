import React from "react";
import InfoModal from "../InfoModal";

export default function TermsConditionsModal() {
    return <InfoModal title="Termos e Condições" info={`
        1. Ao usar este catálogo, você concorda que vai gastar mais tempo escolhendo o filme do que assistindo.

        2. Nenhum filme aqui é garantido ser bom, mas ao menos os pôsteres são bonitos.

        3. Se você discordar da nota de um filme, a culpa é do algoritmo.

        4. Os trailers podem conter cenas fortes de arrependimento.
        
        5. Este site não distribui filmes, apenas frustrações por indecisão.
    `} />;
}