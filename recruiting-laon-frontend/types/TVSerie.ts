import Media from "./Media";
import TVSeason from "./TVSeason";

export default interface TVSerie extends Media {
    seasons: TVSeason[] | null;
}