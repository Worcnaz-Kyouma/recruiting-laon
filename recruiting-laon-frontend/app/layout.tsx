import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";
import { UserStoreProvider } from "@/providers/user-store-provider";
import { Bounce, ToastContainer } from "react-toastify";

// TODO: Inter
const inter = Inter({ subsets: ['latin'] })

export const metadata: Metadata = {
    title: "Laon Catalog",
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
        <UserStoreProvider>
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
        </UserStoreProvider>
    </body>
    </html>
);
}
