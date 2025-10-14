import Image from "next/image";

export default function CatalogLayout({
    children
}: Readonly<{
    children: React.ReactNode;
}>) {
    const externalLinks = [
        { name: "Github", img: "/icons/github.svg", url: "https://github.com/Worcnaz-Kyouma/recruiting-laon"},
        { name: "Linkedin", img: "/icons/linkedin.svg", url: "https://www.linkedin.com/in/nicolas-almeida-prado/"},
        { name: "TMDB", img: "/icons/tmdb.svg", url: "https://www.themoviedb.org/"},
    ];

    return (<div className="min-h-screen flex flex-col bg-gray-100 text-white">
        <header className="flex items-center justify-between p-4 bg-gray-200 border-b border-gray-300">
            <div>
                <span>Catalog</span> {/* Change to logo */}
            </div>
            <div>{/* User avatar and dropdown */}</div>
        </header>
        <main className="flex-grow">
            {children}
        </main>
        <footer className="flex items-center justify-between p-4 border-t border-gray-300">
            <div className="text-white">
                <span className="text-lg">Powered by TMDB API</span> {/* Change to logo */}
            </div>
            <div className="flex items-center space-x-8 text-gray-500 text-base">
                <a href="">Início</a>
                <a href="">Entrar ou Cadastrar</a> {/* If loged, remove */}
                <a href="">Termos e Condições</a>
                <a href="">Política de Privacidade</a>
                <a href="">Ajuda</a>
            </div>
            <nav className="flex space-x-4">
                {externalLinks.map(link => (
                    <a key={link.name} href={link.url} target="_blank" rel="noopener noreferrer" className="w-12 h-12 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-200 transition">
                        <Image src={link.img} alt={link.name} width={24} height={24} className="object-contain" />
                    </a>
                ))}
            </nav>
        </footer>
    </div>);
}