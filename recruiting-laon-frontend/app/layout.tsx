import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "bootstrap/dist/css/bootstrap.min.css";
import "./globals.css";
import { UserStoreProvider } from "@/providers/user-store-provider";

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
            {children}
        </UserStoreProvider>
    </body>
    </html>
);
}
