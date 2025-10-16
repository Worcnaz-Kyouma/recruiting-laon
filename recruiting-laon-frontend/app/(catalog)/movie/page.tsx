import MediaSearcher from "@/components/MediaSearcher";
import { MediaType } from "@/enums/MediaType";

export default function MoviesPage() {
    return <MediaSearcher mediaType={MediaType.Movie} />;
}