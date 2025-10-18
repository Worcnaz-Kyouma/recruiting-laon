"use client"
import Media from "@/types/Media";
import { JSX } from "react";
import { createStore } from "zustand";

// TODO: Improve Modals data structure
export type AppState = {
    currentModal: JSX.Element | undefined
    lastMediaTitleSearched: string;
    selectedMedias: Media[];
}
export type AppAction = {
    setCurrentModal: (modal: JSX.Element) => void;
    closeCurrentModal: () => void;

    setLastMediaTitleSearched: (title: string) => void;

    addMediaIntoSelectedMedias: (media: Media) => void;
    removeMediaFromSelectedMedias: (media: Media) => void;
    clearSelectedMedias: () => void;
}
export type AppStore = AppState & AppAction;


export const defaultInitState: AppState = {
    currentModal: undefined,
    lastMediaTitleSearched: "",
    selectedMedias: []
}

export const initAppStore = (): AppState => {
    return defaultInitState;
}
export const createAppStore = (
    initState: AppState = defaultInitState
) => {
    return createStore<AppStore>()((set) => ({
        ...initState,
        setCurrentModal: (modal: JSX.Element) => set(() => ({ 
            currentModal: modal
        })),
        closeCurrentModal: () => set(() => ({
            currentModal: undefined
        })),
        setLastMediaTitleSearched: (title: string) => set(() => ({
            lastMediaTitleSearched: title
        })),
        addMediaIntoSelectedMedias: (media: Media) => set((state) => ({
            selectedMedias: [...state.selectedMedias, media]
        })),
        removeMediaFromSelectedMedias: (media: Media) => set((state) => ({
            selectedMedias: state.selectedMedias.filter(sm => sm.tmdbId !== media.tmdbId)
        })),
        clearSelectedMedias: () => set(() => ({
            selectedMedias: []
        }))
    }));
}