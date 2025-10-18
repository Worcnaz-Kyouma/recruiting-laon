import Actor from "./Actor";
import Director from "./Director";
import Genre from "./Genre";
import PortugueseInfos from "./PortugueseInfos";

export default interface Media {
    id?: number;
    tmdbId: number;
    title: string;
    releaseDate: string | null;
    genres: Genre[] | null;
    durationStringfied: string | null;
    overview: string | null;
    actors: Actor[] | null;
    directors: Director[] | null;
    review: number | null;
    reviewCount: number | null;
    posterImgUrl: string | null;
    youtubeTrailerVideoUrl: string | null;
    portugueseInfos: PortugueseInfos | null;
}