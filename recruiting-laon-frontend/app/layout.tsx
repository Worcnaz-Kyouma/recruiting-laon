import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";
import { Bounce, ToastContainer } from "react-toastify";
import { StyledEngineProvider } from "@mui/material/styles";
import { GlobalStyles } from "@mui/styled-engine";

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
        {/* <StyledEngineProvider enableCssLayer>
            <GlobalStyles styles="@layer theme, base, mui, components, utilities;" /> */}
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
        {/* </StyledEngineProvider> */}
    </body>
    </html>
);
}
