import React, { useRef, useCallback, useEffect } from 'react';

export default function useNativeEvent(RefElement = null) {

    const mapEntry = (entry) => {
        let return_statement = entry;
        if(entry.current) {
            return_statement = entry.current;
        }
        return return_statement;
    }

    let elToListen = null;
    useEffect(() => {
        elToListen = RefElement ? mapEntry(RefElement) : document;
    }, [])

    const onCb = useCallback((name = '', fn = () => {}, listenerOpts = false) => {
        elToListen.addEventListener(name, fn, listenerOpts);
    }, [])

    const offCb = useCallback((name = '', fn = () => {}, listenerOpts = false) => {
        elToListen.removeEventListener(name, fn, listenerOpts);
    }, [])

    const listenCb = useCallback((name = '', fn = () => {}, listenerOpts = false) => {
        useEffect(() => {
            onCb(name, fn, listenerOpts);
            return () => {
                offCb(name, fn, listenerOpts);
            }
        }, [])
    }, []) 

    let methods = {
        on : onCb,
        off : offCb,
        listen: listenCb
    }

    return methods;
}