"use client"
import CustomInput from "@/components/CustomInput";
import UserContentTitle from "@/components/UserContentTitle";
import { User } from "@/types/User";
import AppAPIClient from "@/utils/AppAPIClient";
import { invokeToastsUsingError } from "@/utils/utils";
import { useRouter } from "next/navigation";

export default function RegisterPage() {
    const router = useRouter();

    const handleRegister = async function(event: React.FormEvent<HTMLFormElement>) {
        event.preventDefault();
        
        const formData = new FormData(event.currentTarget);
        const data = {
            name: formData.get("username"),
            email: formData.get("email"),
            password: formData.get("password"),
            password_confirmation: formData.get("password_confirmation"),
        };
        
        try {
            await AppAPIClient.initializeCSRFProtection();

            const registerResponse = await AppAPIClient.fetchAPI("user", "", "POST", data);
            const user = registerResponse.user as User;
            
            localStorage.setItem("user", JSON.stringify(user));

            router.push("/");
        } catch(err) {
            invokeToastsUsingError(err);
        }
    }

    return <form onSubmit={handleRegister} className="min-w-[560px] max-w-[600px] rounded-[8px] m-12 bg-gray-200 p-16 px-[90px]">
        <UserContentTitle title="Cadastre-se!" styleText="Acompanhe so as melhores com o Catalogo Laon!" />
        <div className="flex flex-col gap-6 mb-3 w-full">
            <CustomInput name="username" placeholder="Nome Completo" />
            <CustomInput name="email" placeholder="Email"/>
            <div className="flex gap-2">
                <CustomInput name="password" placeholder="Senha" type="password"/>
                <CustomInput name="password_confirmation" placeholder="Confirmar Senha" type="password"/>
            </div>
        </div>
        <p className="font-normal text-xs leading-[18px] tracking-normal mb-6 text-gray-500">Ao clicar em <b>cadastrar</b>, você está aceitando os Termos e Condições e a Política de Privacidade da Laon.</p>
        <button className="btn-primary">
            Cadastrar
        </button>
    </form>;
}