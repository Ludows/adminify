import React, { useRef, useCallback, useEffect } from 'react';

export default function useGlide() {

    useEffect(() => {
        return () => {
            // emitter.current.clearListeners();
        }
    })

    const createGlideUrlCb = useCallback((url, config) => {

    }, [])

    return [createGlideUrlCb];
}