// Front Auth middleware, using API token
import { NextRequest, NextResponse } from "next/server";

// TODO: I dont want to redirect user, i want to open a modal on its screen telling him to login!
export function middleware(request: NextRequest) {
    console.log("test");
    const appToken = request.cookies.get("laravel-session");
    if(!appToken) return NextResponse.redirect(new URL("/", request.url));

    return NextResponse.next();
}

export const config = {
    matcher: [
        '/movies/:path*',
        '/tv-series/:path*'
    ]
}