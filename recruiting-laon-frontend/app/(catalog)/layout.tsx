"use client"
import AddMediaToExistingListButton from "@/components/AddMediaToExistingListButton";
import CatalogFooter from "@/components/CatalogFooter";
import CatalogHeader from "@/components/CatalogHeader";
import FixedCustomButton from "@/components/FixedCustomButton";
import ManageMediaListButton from "@/components/ManageMediaListButton";
import { useAppStore } from "@/providers/user-store-provider";
import { usePathname } from "next/navigation";
import { Minus } from "phosphor-react";

export default function CatalogLayout({
    children
}: Readonly<{
    children: React.ReactNode;
}>) {
    const { selectedMedias, clearSelectedMedias } = useAppStore(state => state);
    const pathname = usePathname();
    const isOnMediaDetails = pathname.includes("/tv-serie/") || pathname.includes("/movie/"); 

    return (<div className="min-h-screen flex flex-col text-white">
        <CatalogHeader />
        <main className="relative w-full flex-grow flex flex-col">
            {!isOnMediaDetails && <div className="absolute top-0 left-0 w-full h-65 bg-gray-200 -z-10"></div>}
            <div className="flex-grow flex">{children}</div>
        </main>
        <CatalogFooter />

        {selectedMedias.length > 0 && <div className="fixed bottom-8 right-12 flex gap-4 z-100">
            <FixedCustomButton icon={<Minus weight="bold" size={20}/>} text="LIMPAR SELEÇÃO" onClick={clearSelectedMedias}/>
            <AddMediaToExistingListButton />
            <ManageMediaListButton />
        </div>}
    </div>);
}