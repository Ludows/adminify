import React,{ useEffect, useContext, useState, useRef, useCallback, useMemo } from 'react';
import { EmitterContext } from "@/back/js/contexts/EmitterContext";
import useHelpers from './useHelpers';
export default function useMediaPreview(config = {}) {

    let conf = useMemo(() => {
        return {
            useListeners : false,
            ...config
        }
    }, [config])

    const { event } = useHelpers();

    const bindMedia = (datas) => {
        console.log('binded media', datas);
    }

    const onShowCb = useCallback((cb = () => {}) => {
        event('adminify:mediapreview:show', cb);
    })

    const onHideCb = useCallback((cb = () => {}) => {
        event('adminify:mediapreview:hide', cb);
    })
    
    if(conf.useListeners) {
        event('adminify:mediapreview:show_media', bindMedia);
    }

    let methods = {
        onShow : onShowCb,
        onHide : onHideCb
    }

    return methods;
}
