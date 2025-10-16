import MediaSearcher from "@/components/MediaSearcher";
import { MediaType } from "@/enums/MediaType";

export default function TVSeriesPage() {
    return <MediaSearcher mediaType={MediaType.TVSerie} />;
}