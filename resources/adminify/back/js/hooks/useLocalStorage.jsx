import React,{ useCallback } from 'react';

export default function useLocalStorage() {

    const shouldEncodeData = (value) => {}
    const shouldDecodeData = (value) => {}

    const getCallback = useCallback((key) => {
        return localStorage.getItem(key);
    })

    const setCallback = useCallback((key, value) => {

        return localStorage.setItem(key, value);
    })

    return [getCallback, setCallback];
}
