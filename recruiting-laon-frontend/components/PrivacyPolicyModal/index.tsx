import React from "react";
import InfoModal from "../InfoModal";

export default function PrivacyPolicyModal() {
    return <InfoModal title="Política de Privacidade" info={`
        1. Nós respeitamos sua privacidade — principalmente quando você tenta esconder o histórico de filmes ruins.

        2. Se algum cookie aparecer, é só o do lanche mesmo — este site não usa cookies digitais.
        (ainda)[mentira, usa sim]

        3. Suas informações estão seguras, até alguém descobrir a senha do admin, ai sinto muito.
        (obs. você foi avisado)

        4. Ao continuar usando o catálogo, você concorda em ser julgado silenciosamente pelas suas escolhas de filme.    
    `} />;
}