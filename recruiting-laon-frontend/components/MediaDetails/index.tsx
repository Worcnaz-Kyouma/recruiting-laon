"use client"
import Media from "@/types/Media";
import Image from "next/image";
import React from "react";
import CustomLoader from "../CustomLoader";
import Genre from "@/types/Genre";

interface Detail {
    description: string;
    value: string | string[];
}
const PrimaryDetail = ({ description, value }: Readonly<Detail>) => 
    <p className="font-normal text-base leading-6 tracking-normal text-gray-500"><b>{description}:</b> {value}</p>

const GenreDetail = ({ genre }: Readonly<{ genre: Genre }>) => 
    <span className="flex items-center justify-center p-1 px-5 font-normal leading-[24px] tracking-normal border border-gray-300 rounded-[32px]">{genre.name}</span>

const SecondaryDetail = ({ description, value }: Readonly<Detail>) =>
    <div className="flex flex-col gap-4 flex-grow">
        <h2 className="font-semibold text-base leading-6 tracking-normal text-white border-b border-gray-300 py-2">{description}</h2>
        <p className="font-normal text-base leading-6 tracking-normal text-gray-500">{Array.isArray(value)
            ? `${value.slice(0, 6).join(", ")} ${value.length > 6 ? " e outros" : ""}`
            : value   
        }</p>
    </div>

// TODO: Adjust degrade styling box in the background to the Primary details header
export default function MediaDetails({ media }: Readonly<{ media: Media | undefined }>) {
    if(!media)
        return <div className="flex-grow flex items-center justify-center">
            <CustomLoader />
        </div>

    return <div className="flex-grow flex gap-12 px-[90px] py-12">
        <div className="flex flex-col gap-2 items-center">
            <div className="relative w-full min-w-[320px] max-w-[400px] aspect-[306/448]">
                <Image
                    src={media.posterImgUrl || ""}
                    alt={media.title}
                    fill
                    className="rounded"
                />
            </div>
            <button className="btn-primary">Assistir trailer</button>
        </div>
        <div className="flex flex-col gap-15">
            <div className="flex flex-col gap-1">
                <h1 className="font-semibold text-4xl leading-[100%] tracking-normal">{media.titlePortuguese || media.title}</h1>
                {media.titlePortuguese && 
                    <PrimaryDetail description="Título original" value={media.title} />
                }
                <PrimaryDetail description="Ano" value={"2000"/*media.release_date*/} />
                <PrimaryDetail description="Duração" value={media.durationStringfied!} />
                <div className="flex gap-2">{media.genres?.map(genre => <GenreDetail key={genre.tmdbId} genre={genre} />)}</div>
            </div>
            <div className="flex flex-col gap-3">
                <SecondaryDetail description="Sinopse" value={media.overview!} />
                <div className="flex gap-2">
                    {media.actors && <SecondaryDetail description="Elenco" value={media.actors.map(actor => actor.name)} />}
                    {media.directors && <SecondaryDetail description="Diretores" value={media.directors.map(director => director.name)} />}
                </div>
                <div className="flex gap-2">
                    <SecondaryDetail description="Avaliações" value={`TMDB: ${media.review}`} />
                </div>
            </div>
        </div>
    </div>;
}