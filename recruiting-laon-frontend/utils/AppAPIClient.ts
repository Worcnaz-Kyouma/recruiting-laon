import AppError from "@/errors/AppError";
import axios, { AxiosHeaders, Method } from "axios";

type APIResource = "user" | "media" | "movie" | "tv-serie";

export default class AppAPIClient {
    private static readonly backendBaseUrl = process.env.NEXT_PUBLIC_BACKEND_URL || "http://localhost:8000";
    private static readonly apiBaseUrl = `${this.backendBaseUrl}/api`;

    static async fetchAPI(resource: APIResource, endpoint: string, method: Method, data?: object): Promise<any> {
        endpoint = `${resource}/${endpoint}`;

        let headers: AxiosHeaders | undefined;
        
        try {
        const response = await axios({
                baseURL: this.apiBaseUrl,
                url: endpoint,
                method,
                data: ["POST", "PATCH", "PUT", "DELETE"].includes(method) && data,
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