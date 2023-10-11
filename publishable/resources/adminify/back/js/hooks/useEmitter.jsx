import React, { useRef, useCallback, useEffect } from 'react';
import Emittery from 'emittery';

export default function useEmitter() {

    let emitter = useRef( new Emittery() )

    useEffect(() => {

        // console.log('useEmitter onMounted', emitter.current);

        return () => {
            // emitter.current.clearListeners();
        }
    })

    const onMethod = useCallback((eventName, cb = () => {}) => {
        emitter.current.on(eventName, cb)
    })
   
    const offMethod = useCallback((eventName, cb = () => {}) => {
        emitter.current.off(eventName, cb)
    })

    const emitMethod = useCallback((eventName, datas = {}) => {
        emitter.current.emit(eventName, datas)
    })

    return [onMethod, offMethod, emitMethod];
}