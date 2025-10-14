export default class Genre {
    tmdbId: number;
    name: string;

    constructor(tmdbId: number, name: string) {
        this.tmdbId = tmdbId;
        this.name = name;
    }
}