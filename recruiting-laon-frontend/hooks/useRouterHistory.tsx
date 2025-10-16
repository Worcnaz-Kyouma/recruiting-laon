"use client";

import { usePathname } from "next/navigation";
import { useEffect, useState } from "react";

export function useRouterHistory() {
    const pathname = usePathname();
    const [ historyRef, setHistoryRef ] = useState<string[]>([]);

    useEffect(() => {
        setHistoryRef(prev => [ ... prev, pathname ])
    }, [pathname]);

    return historyRef;
}