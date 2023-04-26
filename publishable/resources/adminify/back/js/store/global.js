import { create } from "zustand";

const useGlobalStore = create((set, get) => {
    return {
        data : {},
        translations : {},
        ready : false,
        getAppData : (key) => {
            let datas = get().data;
            if(datas[key]) {
                return datas[key];
            }

            return datas;
        },
        getTranslation: (name = '') => {
            let translations = get().translations;
            if(translations[name]) {
                return translations[name];
            }

            return name;
        },
        getTranslations : (array = []) => {
            let a = [];
            array.forEach(name => {
                a.push( get().getTranslation(name) );
            });

            return a;
        },
        setTranslations : (data) => set((state) => ({...state, translations : data.translations})),
        setReadyState : (data) => set((state) => ({...state, ready : data.ready})),
        commit :  (data) => set((state) => ({...state, data : data.data }))
    }
})

export default useGlobalStore;