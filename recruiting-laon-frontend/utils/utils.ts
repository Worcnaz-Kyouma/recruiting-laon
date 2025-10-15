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
    color: '#3EE48A',
  },
  iconTheme: {
    primary: '#3EE48A',
    secondary: '#FFFAEE',
  },
}

// TODO: Improve it to receive generic Error
export function invokeToastsUsingError(error: AppError) {
    if(typeof error.msg === "string") toast.error(error.msg, errorToastStyle);
    else error.msg.forEach(msg => toast.error(msg, errorToastStyle))
}

// TODO: Maybe JWT?
// OBS to Code Reviewer: Here i could decrypt a JWT to get my user. To mantain simplicity, i choose not too.
export function extractUserFromLocalStorage(): User | null {
    const localStoredUserStringified = localStorage.getItem("user");
    if(!localStoredUserStringified) return null;

    const localStoredUser = JSON.parse(localStoredUserStringified) as User;
    return localStoredUser;
}