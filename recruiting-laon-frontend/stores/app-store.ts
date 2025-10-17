"use client"
import Media from "@/types/Media";
import { createStore } from "zustand";

// TODO: Improve Modals data structure
export type AppState = {
    isUnauthorizedNavBlockModalOpen: boolean;
    isCreateMediaListModalOpen: boolean;
    isRemoveMediasFromMediaListModalOpen: boolean;
    selectedMedias: Media[];
}
export type AppAction = {
    setIsUnauthorizedNavBlockModalOpen: (isUnauthorizedNavBlockModalOpen: boolean) => void;
    setIsCreateMediaListModalOpen: (isCreateMediaListModalOpen: boolean) => void;
    setIsRemoveMediasFromMediaListModalOpen: (isRemoveMediasFromMediaListModalOpen: boolean) => void;

    addMediaIntoSelectedMedias: (media: Media) => void;
    removeMediaFromSelectedMedias: (media: Media) => void;
    clearSelectedMedias: () => void;
}
export type AppStore = AppState & AppAction;


export const defaultInitState: AppState = {
    isUnauthorizedNavBlockModalOpen: false,
    isCreateMediaListModalOpen: false,
    isRemoveMediasFromMediaListModalOpen: false,
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
        setIsUnauthorizedNavBlockModalOpen: (isUnauthorizedNavBlockModalOpen: boolean) => set(() => ({ 
            isUnauthorizedNavBlockModalOpen 
        })),
        setIsCreateMediaListModalOpen: (isCreateMediaListModalOpen: boolean) => set(() => ({ 
            isCreateMediaListModalOpen 
        })),
        setIsRemoveMediasFromMediaListModalOpen: (isRemoveMediasFromMediaListModalOpen: boolean) => set(() => ({ 
            isRemoveMediasFromMediaListModalOpen 
        })),

        addMediaIntoSelectedMedias: (media: Media) => set((state) => ({
            selectedMedias: [...state.selectedMedias, media]
        })),
        removeMediaFromSelectedMedias: (media: Media) => set((state) => ({
            selectedMedias: state.selectedMedias.filter(sm => sm !== media)
        })),
        clearSelectedMedias: () => set(() => ({
            selectedMedias: []
        }))
    }));
}