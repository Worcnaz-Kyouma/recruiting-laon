import TopPopularMedias from "@/components/TopPopularMedias";
import { MediaType } from "@/enums/MediaType";
import { Suspense } from "react";

export default async function HomePage() {
    const medias = await fetch("http://localhost:8000/api/media/top-popular");
    const mediasJson = await medias.json();
    
    return <div className="flex flex-col gap-[40px] p-8 px-[90px] pb-16">
        <h1 className="text-2xl font-semibold text-white">Populares</h1>
        <Suspense fallback={<>
            <TopPopularMedias mediaType={MediaType.Movie} medias={null} />
            <TopPopularMedias mediaType={MediaType.TVSerie} medias={null} />
        </>}>
            <TopPopularMedias mediaType={MediaType.Movie} medias={mediasJson.movies} />
            <TopPopularMedias mediaType={MediaType.TVSerie} medias={mediasJson.tvSeries} />
        </Suspense>
    </div>;
}