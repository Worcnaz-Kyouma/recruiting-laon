import Media from "@/types/Media";
import Image from "next/image";
import React from "react";
import CustomLoader from "../CustomLoader";

interface Detail {
    description: string;
    value: string;
}
const PrimaryDetail = ({ description, value }: Readonly<Detail>) => 
    <p className="font-normal text-base leading-6 tracking-normal text-gray-500"><b>{description}:</b> {value}</p>

const SecondaryDetail = ({ description, value }: Readonly<Detail>) =>
    <div className="flex flex-col gap-1">
        <h2 className="font-semibold text-base leading-6 tracking-normal text-gray-500 border-b border-gray-300">{description}</h2>
        <p className="font-normal text-base leading-6 tracking-normal text-gray-500">{value}</p>
    </div>

export default function MediaDetails({ media }: Readonly<{ media: Media | undefined }>) {
    if(!media)
        return <div className="flex-grow flex items-center justify-center">
            <CustomLoader />
        </div>

    return <div className="flex justify-between">
        <div className="flex flex-col gap-2">
            <div className="relative w-full max-w-md aspect-[780/1170]">
                <Image
                    src={media.posterImgUrl || ""}
                    alt={media.title}
                    fill
                    className="object-contain rounded"
                />
            </div>
            <button className="btn-primary">Assistir trailer</button>
        </div>
        <div className="flex flex-col gap-6">
            <div className="flex flex-col gap-1">
                <h1>{media.titlePortuguese || media.title}</h1>
                {media.titlePortuguese && 
                    <PrimaryDetail description="Título original" value={media.title} />
                }
                <PrimaryDetail description="Ano" value={"2000"/*media.release_date*/} />
                <PrimaryDetail description="Duração" value={media.durationStringfied!} />
                <div className="flex gap-2">{media.genres?.map(genre => 
                    <span className="flex items-center justify-center p-1 px-2 border border-gray-300 rounded-[8px]">{genre.name}</span>
                )}</div>
            </div>
            <div className="flex flex-col gap-3">
                <SecondaryDetail description="Sinopse" value={media.overview!} />
                <div className="flex gap-2">
                    <SecondaryDetail description="Elenco" value={media.actors?.map(actor => actor.name).join(", ")!} />
                    <SecondaryDetail description="Diretores" value={media.directors?.map(director => director.name).join(", ")!} />
                </div>
                <div className="flex gap-2">
                    <SecondaryDetail description="Avaliações" value={`TMDB: ${media.review}`} />
                </div>
            </div>
        </div>
    </div>;
}