import Image from "next/image";

export default function ExternalRedirectsNav() {
    const externalLinks = [
        { name: "Github", img: "/icons/github.svg", url: "https://github.com/Worcnaz-Kyouma/recruiting-laon"},
        { name: "Linkedin", img: "/icons/linkedin.svg", url: "https://www.linkedin.com/in/nicolas-almeida-prado/"},
        { name: "TMDB", img: "/icons/tmdb.svg", url: "https://www.themoviedb.org/"},
    ];

    return <nav className="flex space-x-4">
        {externalLinks.map(link => (
            <a key={link.name} href={link.url} target="_blank" rel="noopener noreferrer" className="w-12 h-12 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-300 transition">
                <Image src={link.img} alt={link.name} width={20} height={20} className="object-contain" />
            </a>
        ))}
    </nav>
}