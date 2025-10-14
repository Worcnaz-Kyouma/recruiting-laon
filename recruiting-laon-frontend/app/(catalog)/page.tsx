'use client';

import TopPopularMedias from "@/components/TopPopularMedias";
import { MediaType } from "@/enums/MediaType";

export default function HomePage() {
    return <div className="flex flex-col gap-[40px] p-8 px-16">
        <h1 className="text-2xl font-semibold text-white">Populares</h1>
        <TopPopularMedias mediaType={MediaType.Movie} medias={null} />
        <TopPopularMedias mediaType={MediaType.TVSerie} medias={null} />
    </div>;
}