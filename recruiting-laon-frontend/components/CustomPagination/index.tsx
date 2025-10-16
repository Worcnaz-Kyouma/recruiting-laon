"use client";
import Pagination from "@mui/material/Pagination";
import PaginationItem from "@mui/material/PaginationItem";
import React from "react";

interface CustomPaginationProps {
    numberOfPages: number;
    page: number;
    setPage: React.Dispatch<React.SetStateAction<number>>;
    
    isLoading: boolean;
    afterChange?: (newPage: number) => void;
}

export default function CustomPagination({
    numberOfPages,
    page,
    setPage,
    isLoading,
    afterChange
}: CustomPaginationProps) {
    const onPageSwitch = (e: React.ChangeEvent<unknown>, value: number) => {
        const newPage = value;
        setPage(newPage);

        if(typeof afterChange !== 'undefined') 
            afterChange(newPage);
    }

    return <Pagination count={numberOfPages} page={page} onChange={onPageSwitch} className="flex justify-end mt-4" color="primary" disabled={isLoading} renderItem={(item) => (
        <PaginationItem 
            {... item}
            className={`
                !rounded-md
                !border
                !px-4 !py-2
                !h-fit
                !text-2xl
                !bg-transparent
                ${item.selected
                    ? "!border-blue-600 !text-blue-600"
                    : "!border-gray-300 !text-white"
                }
            `}
        />
    )} />;
}