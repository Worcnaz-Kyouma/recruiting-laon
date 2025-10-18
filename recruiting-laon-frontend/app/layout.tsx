import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";
import { Bounce, ToastContainer } from "react-toastify";
import { AppStoreProvider } from "@/providers/user-store-provider";
import ModalsContainer from "@/components/ModalsContainer";

const inter = Inter({ subsets: ['latin'] })

export const metadata: Metadata = {
    title: "Laon Streaming",
    description: "Movies and TV series catalog app",
};

export default function RootLayout({
    children,
}: Readonly<{
    children: React.ReactNode;
}>) {
return (
    <html lang="pt-BR">
    <body
        className={`${inter.className} bg-gray-100 antialiased`}
    >
        <AppStoreProvider >
            <ToastContainer
                position="top-right"
                autoClose={5000}
                hideProgressBar={false}
                pauseOnFocusLoss
                pauseOnHover
                theme="colored"
                transition={Bounce}
            />
            {children}
            <ModalsContainer />
        </AppStoreProvider>
    </body>
    </html>
);
}
