'use client';

import { ArrowRight } from "phosphor-react";

export default function HomePage() {
    return <div className="flex flex-col gap-[40px] p-8 px-12">
        <h1 className="text-xl font-semibold text-white">Populares</h1>
        <div>
            <div>
                <h2 className="text-sm">FILMES</h2>
                <div className="w-12 h-12 rounded-full border flex items-center justify-center cursor-pointer hover:bg-gray-200 transition">
                    <ArrowRight size={24} className="text-white" />
                </div>
            </div>
            <div className="w-full flex gap-2">

            </div>
        </div>
        <div></div>
    </div>;
}