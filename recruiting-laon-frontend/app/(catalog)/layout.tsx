import CatalogFooter from "@/components/CatalogFooter";
import CatalogHeader from "@/components/CatalogHeader";

export default function CatalogLayout({
    children
}: Readonly<{
    children: React.ReactNode;
}>) {
    return (<div className="min-h-screen flex flex-col text-white">
        <CatalogHeader />
        <main className="relative w-full flex-grow flex flex-col">
            <div className="absolute top-0 left-0 w-full h-1/4 bg-gray-200 -z-10"></div>
            <div className="flex-grow flex">{children}</div>
        </main>
        <CatalogFooter />
    </div>);
}