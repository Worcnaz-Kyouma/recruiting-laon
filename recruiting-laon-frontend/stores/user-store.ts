// "use client"
// import { User } from "@/types/User";
// import { createStore } from "zustand";

// export type UserState = {
//     user: User | null;
// }
// export type UserAction = {
//     setUser: (user: User) => void;
//     clearUser: () => void;
// }
// export type UserStore = UserState & UserAction;


// export const defaultInitState: UserState = {
//     user: null
// }

// export const initUserStore = (): UserState => {
//     return defaultInitState;
// }
// export const createUserStore = (
//     initState: UserState = defaultInitState
// ) => {
//     return createStore<UserStore>()((set) => ({
//         ...initState,
//         setUser: (user: User) => set(() => ({ user })),
//         clearUser: () => set(() => ({ user: null })),
//     }));
// }