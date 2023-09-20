
import React, { useCallback } from 'react';
import usePageProps from './usePageProps';
export default function useTranslations() {
    
    const { get } = usePageProps();
    // const getTranslation = useGlobalStore(state => state.getTranslation);
    const getFileTranslations = useCallback(() => {
        return window['messages_'+ document.documentElement.getAttribute('lang')]
    }, [])

    const getTranslationCb = useCallback((name = '', loadedTranslations = null) => {
        let trans = loadedTranslations;
        if(!loadedTranslations) {
            trans = getFileTranslations();
        }

        if(trans[name]) {
            return trans[name];
        }

        return name;
    }, [])

    const getTranslationsCb = useCallback((array = []) => {
        let o = {};
        let trans = getFileTranslations();
        array.forEach(name => {
            o[name] = getTranslationCb(name, trans);
        });

        return o;
    }, [])

    let methods = {
        get : getTranslationCb,
        getTranslations : getTranslationsCb
    }

    return methods;
}
