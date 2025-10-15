import AppError from "@/errors/AppError";
import axios, { AxiosHeaders, Method } from "axios";

type APIResource = "user" | "media" | "movie" | "tv-serie";

export default class AppAPIClient {
    private static readonly baseUrl = "http://localhost:8000/api"

    static async fetchAPI(resource: APIResource, endpoint: string, method: Method, body?: object, params?: object): Promise<any> {
        endpoint = `${resource}/${endpoint}`;

        const apiToken = localStorage.getItem('api_token');
        let headers: AxiosHeaders | undefined;
        if(apiToken) {
            headers = new AxiosHeaders();
            headers.set('Authorization', `Bearer ${apiToken}`)
        }
        
        try {
        const response = await axios({
                baseURL: this.baseUrl,
                url: endpoint,
                method,
                data: body,
                params: params,
                headers: {
                    'Content-Type': 'application/json',
                    ... headers
                },
            });
            return response.data;
        } catch (error: any) {
            throw new AppError(error.response?.data?.error || error.message || error);
        }
    }
}