import AppError from "@/errors/AppError";
import { User } from "@/types/User";
import { toast } from "react-toastify"

export const errorToastStyle = {
    style: {
        padding: '16px',
        color: '#ffffff',
    },
    iconTheme: {
        primary: '#E43E3E',
        secondary: '#FFFAEE',
    },
}

export const successToastStyle = {
    style: {
        padding: '16px',
        color: '#FFFFFF',
    },
    iconTheme: {
        primary: '#3EE48A',
        secondary: '#FFFAEE',
    },
}

export function handleError(error: Error) {
    if(!(error instanceof AppError)) {
        console.error(error.message);
        return;
    }

    if(error.status === 401)
        window.location.href = '/';

    invokeToastsUsingError(error as AppError);
}

export function invokeToastsUsingError(error: AppError) {
    if(typeof error.msg === "string") toast.error(error.msg, errorToastStyle);
    else error.msg.forEach(msg => toast.error(msg, errorToastStyle))
}

export function extractUserFromLocalStorage(): User | null {
    const localStoredUserStringified = localStorage.getItem("user");
    if(!localStoredUserStringified) return null;

    const localStoredUser = JSON.parse(localStoredUserStringified) as User;
    return localStoredUser;
}