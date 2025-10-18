import Actor from "./Actor";
import Director from "./Director";
import Genre from "./Genre";

export default interface Media {
    id?: number;
    tmdbId: number;
    title: string;
    titlePortuguese: string | null;
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
}