import AppError from "@/errors/AppError";
import axios, { AxiosHeaders, Method } from "axios";

type APIResource = "user" | "media" | "movie" | "tv-serie";

export default class AppAPIClient {
    private static readonly backendBaseUrl = "http://localhost:8000"
    private static readonly apiBaseUrl = `${this.backendBaseUrl}/api`

    static async fetchAPI(resource: APIResource, endpoint: string, method: Method, data?: object): Promise<any> {
        endpoint = `${resource}/${endpoint}`;

        // const apiToken = localStorage.getItem('api_token');
        let headers: AxiosHeaders | undefined;
        // if(apiToken) {
        //     headers = new AxiosHeaders();
        //     headers.set('Authorization', `Bearer ${apiToken}`)
        // }
        
        try {
        const response = await axios({
                baseURL: this.apiBaseUrl,
                url: endpoint,
                method,
                data: ["POST", "PATCH", "PUT"].includes(method) && data,
                params: method === "GET" && data,
                withCredentials: true,
                withXSRFToken: true,
                headers: {
                    'Content-Type': 'application/json',
                    ... headers
                },
            });
            return response.data;
        } catch (error: any) {
            throw new AppError(error.status, error.response?.data?.error || error.message || error);
        }
    }

    static async initializeCSRFProtection() {
        return await axios.get(`${this.backendBaseUrl}/sanctum/csrf-cookie`, {
            withCredentials: true,
            withXSRFToken: true
        });
    }
}