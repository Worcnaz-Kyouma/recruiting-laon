"use client"
import CustomInput from "@/components/CustomInput";
import UserContentTitle from "@/components/UserContentTitle";
import { User } from "@/types/User";
import AppAPIClient from "@/utils/AppAPIClient";
import { handleError } from "@/utils/utils";
import { useRouter } from "next/navigation";

export default function LoginPage() {
    const router = useRouter();
    

    const handleLogin = async function(event: React.FormEvent<HTMLFormElement>) {
        event.preventDefault();
                
        const formData = new FormData(event.currentTarget);
        const data = {
            email: formData.get("email"),
            password: formData.get("password")
        };
        
        try {
            await AppAPIClient.initializeCSRFProtection();

            const registerResponse = await AppAPIClient.fetchAPI("user", "login", "POST", data);
            const user = registerResponse.user as User;
            
            localStorage.setItem("user", JSON.stringify(user));
            localStorage.setItem("api_token", registerResponse.token);

            router.push("/");
        } catch(err) {
            handleError(err);
        }
    }

    return <form onSubmit={handleLogin} className="min-w-[500px] max-w-[600px] rounded-[8px] m-12 bg-gray-200 p-16 px-[90px]">
        <UserContentTitle title="Entrar" styleText="Bem vindo(a) de volta!" />
        <div className="flex flex-col gap-6 mb-8 w-full">
            <CustomInput name="email" placeholder="Email"/>
            <CustomInput name="password" placeholder="Senha" type="password"/>
        </div>
        <button className="cursor-pointer w-full p-4 bg-white rounded-[4px] font-semibold text-black text-base leading-[24px] tracking-normal">
            Entrar
        </button>
    </form>;
}