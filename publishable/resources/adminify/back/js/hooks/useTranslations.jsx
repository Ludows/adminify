
import React, {} from 'react';
import useGlobalStore from '../store/global';

export default function useTranslations() {
    
    const getTranslation = useGlobalStore(state => state.getTranslation);

    let methods = {
        get : getTranslation
    }

    return methods;
}
