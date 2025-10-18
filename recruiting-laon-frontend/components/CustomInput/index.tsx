"use client";

import { Eye, EyeSlash } from "phosphor-react";
import { useState, InputHTMLAttributes, HTMLInputTypeAttribute } from "react";

interface CustomInputProps extends InputHTMLAttributes<HTMLInputElement> {
    placeholder: string;
    value?: string;
    setValue?: React.Dispatch<React.SetStateAction<string>>;
    type?: HTMLInputTypeAttribute;
}

export default function CustomInput({ value, setValue, placeholder, type = "text", ...props }: CustomInputProps) {
    const [isPasswordVisible, setIsPasswordVisible] = useState(false);

    const togglePassword = () => setIsPasswordVisible(!isPasswordVisible);

    const onChange = setValue
        ? (event: React.ChangeEvent<HTMLInputElement>) => setValue(event.target.value)
        : undefined;

    return (
        <div className="relative flex-grow">
            <input
                name={props.name}
                value={value}
                onChange={onChange}
                type={type === "password" && isPasswordVisible ? "text" : type}
                placeholder={placeholder}
                className={`
                    w-full rounded-sm border border-gray-300
                    px-4 py-6 text-white placeholder-gray-500
                    focus:outline-none focus:border-blue-500
                `}
                onKeyDown={props.onKeyDown}
            />
            {type === "password" && (<button
                type="button"
                onClick={togglePassword}
                className="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white"
            >{isPasswordVisible ? (
                <Eye className="w-5 h-5" />
            ) : (
                <EyeSlash className="w-5 h-5" />
            )}
            </button>)}
        </div>
    );
}
