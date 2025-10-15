import Actor from "./Actor";
import Director from "./Director";
import Genre from "./Genre";

export default interface Media {
    tmdbId: number;
    title: string;
    titlePortuguese: string | null;
    genres: Genre[] | null;
    durationStringfied: string | null;
    overview: string | null;
    actors: Actor[] | null;
    directors: Director[] | null;
    review: number;
    reviewCount: number;
    posterImgUrl: string | null;
}