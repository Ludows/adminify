import { create } from "zustand";

const useGlobalStore = create((set, get) => {
    return {
        data : {},
        ready : false,
        getAppData : (key) => {
            let datas = get().data;
            if(datas[key]) {
                return datas[key];
            }

            return datas;
        },
        setReadyState : (data) => set((state) => ({...state, ready : data.ready})),
        commit :  (data) => set((state) => ({...state, data : data.data }))
    }
})

export default useGlobalStore;