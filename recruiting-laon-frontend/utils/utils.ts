import AppError from "@/errors/AppError";
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

export function invokeToastsUsingError(error: AppError) {
    if(typeof error.msg === "string") toast.error(error.msg, errorToastStyle);
    else error.msg.forEach(msg => toast.error(msg, errorToastStyle))
}