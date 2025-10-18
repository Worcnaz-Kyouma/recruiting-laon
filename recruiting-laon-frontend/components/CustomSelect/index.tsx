"use client";
import { CaretDown } from "phosphor-react";
import SelectOption from "@/types/SelectOption"
import React from "react";

interface CustomSelectProps {
    value: string | undefined;
    setValue: (value: string) => void;
    options: SelectOption[];
    className?: string;
}

export default function CustomSelect({ value, setValue, options, className }: CustomSelectProps) {
    const handleChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        setValue(e.target.value);
    };

    if(options.length < 1) return <div className={`w-40 min-h-[40px] border bg-gray-300 border-gray-400 rounded-md transition animate-pulse ${className}`}></div>

    return <div className={`relative inline-block min-w-40 ${className}`}>
        <select
            value={value}
            onChange={handleChange}
            className="
                appearance-none w-full h-full text-white border border-gray-300 rounded-md 
                px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500
            "
        >
            {options.map((opt) => (
            <option key={opt.value} value={opt.value} className="bg-gray-800 text-white">
                {opt.description}
            </option>
            ))}
        </select>

        <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <CaretDown weight="bold" size={20}/>
        </div>
    </div>;
}