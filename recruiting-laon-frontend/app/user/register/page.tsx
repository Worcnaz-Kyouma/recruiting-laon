"use client"
import CustomInput from "@/components/CustomInput";

export default function RegisterPage() {
    const handleRegister = function(event: React.FormEvent<HTMLFormElement>) {
        event.preventDefault();
        
        const formData = new FormData(event.currentTarget);
        const data = {
            username: formData.get("username"),
            email: formData.get("email"),
            password: formData.get("password"),
            password_confirmation: formData.get("password_confirmation"),
        };
        console.log(data);
    }

    return <form onSubmit={handleRegister} className="min-w-[560px] max-w-[600px] rounded-[8px] bg-gray-200 p-16 px-[90px]">
        <div className="flex flex-col gap-2 mb-8">
            <h1 className="font-semibold text-2xl leading-[30px] tracking-normal text-white">Cadastre-se!</h1>
            <p className="font-normal text-base leading-[24px] tracking-normal text-gray-500">Acompanhe so as melhores com o Catalogo Laon!</p>
        </div>
        <div className="flex flex-col gap-6 mb-4 w-full">
            <CustomInput name="username" placeholder="Nome Completo" />
            <CustomInput name="email" placeholder="Email"/>
            <div className="flex gap-2">
                <CustomInput name="password" placeholder="Senha" type="password"/>
                <CustomInput name="password_confirmation" placeholder="Confirmar Senha" type="password"/>
            </div>
        </div>
        <p className="font-normal text-xs leading-[18px] tracking-normal mb-6 text-gray-500">Ao clicar em <b>cadastrar</b>, você está aceitando os Termos e Condições e a Política de Privacidade da Laon.</p>
        <button className="cursor-pointer w-full p-4 bg-white rounded-[4px] font-semibold text-black text-base leading-[24px] tracking-normal">
            Cadastrar
        </button>
    </form>;
}