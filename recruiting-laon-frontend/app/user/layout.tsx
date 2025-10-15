import UserHeader from "@/components/UserHeader";

export default function UserLayout({
    children
}: Readonly<{
    children: React.ReactNode;
}>) {
    return (<div className="min-h-screen flex flex-col text-white">
        <UserHeader />
        <main className="w-full flex-grow flex items-center justify-center">
            {children}
        </main>
    </div>);
}