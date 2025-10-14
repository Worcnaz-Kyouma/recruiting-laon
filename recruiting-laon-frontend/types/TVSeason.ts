import TVEpisode from "./TVEpisode";

export default interface TVSeason {
    tmdbId: number;
    seasonNumber: number;
    name: string;
    posterImgUrl: string | null;
    episodes: TVEpisode[] | null;
}