import React from "react";

interface UserContentTitle {
    title: string;
    styleText?: string;
}

export default function UserContentTitle({ title, styleText }: UserContentTitle) {
    return <div className="flex flex-col gap-2 mb-8">
        <h1 className="font-semibold text-2xl leading-[30px] tracking-normal text-white">{title}</h1>
        {styleText && <p className="font-normal text-base leading-[24px] tracking-normal text-gray-500">{styleText}</p>}
    </div>;
}