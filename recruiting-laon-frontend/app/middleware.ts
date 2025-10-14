// Front Auth middleware, using API token
import { NextRequest, NextResponse } from "next/server";

// TODO: I dont want to redirect user, i want to open a modal on its screen telling him to login!
export function middleware(request: NextRequest) {
    const auth = request.headers.get("Authorization");
    const jwtToken = auth && auth.split(' ')[1];
    if(!jwtToken) return NextResponse.redirect(new URL("/user/login", request.url));

    // OBS to Code Reviewer: We could make a request here to api, verifying the API Key. But i dont think it would be worth, cause if it not valid the API will not work anyway, so crackers would gain nothing writing a false key in the storage

    return NextResponse.next();
}

export const config = {
    matcher: [
        '/movies/*',
        '/tv-series/*'
    ]
}