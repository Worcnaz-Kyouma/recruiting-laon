"use client"
import { createStore } from "zustand";

export type AppState = {
    isUnauthorizedNavBlockModalOpen: boolean;
}
export type AppAction = {
    setIsUnauthorizedNavBlockModalOpen: (isUnauthorizedNavBlockModalOpen: boolean) => void;
}
export type AppStore = AppState & AppAction;


export const defaultInitState: AppState = {
    isUnauthorizedNavBlockModalOpen: false
}

export const initAppStore = (): AppState => {
    return defaultInitState;
}
export const createAppStore = (
    initState: AppState = defaultInitState
) => {
    return createStore<AppStore>()((set) => ({
        ...initState,
        setIsUnauthorizedNavBlockModalOpen: (isUnauthorizedNavBlockModalOpen: boolean) => set(() => ({ 
            isUnauthorizedNavBlockModalOpen 
        })),
    }));
}