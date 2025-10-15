import { User } from "@/types/User";
import { extractUserFromLocalStorage } from "@/utils/utils";
import { useEffect, useState } from "react";

export default function useUser(): User | null {
    const [user, setUser] = useState<User | null>(null);

    useEffect(() => {
        const localStoredUser = extractUserFromLocalStorage();
        setUser(localStoredUser);
    }, []);

    return user;
};