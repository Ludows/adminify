import React,{ useEffect, useContext, useState, useRef, useCallback, useMemo } from 'react';
import { EmitterContext } from "@/back/js/contexts/EmitterContext";

export default function useMediaPicker(config = {}) {

    let conf = useMemo(() => {
        return {
            useListeners : false,
            ...config
        }
    }, [config])

    const [selection, setSelection] = useState([]);
    const [on, off, emit] = useContext(EmitterContext);

    const addSelectionHandler = (datas) => {
        // console.log('adminify:mediapicker:add', datas)
        setSelection((sel) => [...sel, datas]);
    }
    const removeSelectionHandler = (datas) => {
        // console.log('adminify:mediapicker:remove', datas)
        setSelection((sel) => sel.filter((media) => media.id != datas.id));
    }

    const emptySelectionHandler = (datas) => {
        // console.log('adminify:mediapicker:remove', datas)
        setSelection([]);
    }

    useEffect(() => {
        emit('adminify:mediapicker:selection_updated', selection);
    }, [selection]);

    // const mediaPickerResults = (datas) => {

    // }

    useEffect(() => {
        // console.log('useMediaPicker.jsx mounted');
        if(conf.useListeners) {
            on('adminify:mediapicker:add', addSelectionHandler);
            on('adminify:mediapicker:empty', emptySelectionHandler);
            on('adminify:mediapicker:remove', removeSelectionHandler);
        }
        
        return () => {
            if(conf.useListeners) {
                off('adminify:mediapicker:add', addSelectionHandler);
                off('adminify:mediapicker:empty', emptySelectionHandler);
                off('adminify:mediapicker:remove', removeSelectionHandler);
            }
          }
    }, [])

    const showCallback = useCallback((datas = {}) => {
        emit('adminify:mediapicker:show', datas);
    })

    const configCallback = useCallback((datas = {}) => {
        emit('adminify:mediapicker:config', datas);
    })

    const resultsCallback = useCallback((datas = {}) => {
        emit('adminify:mediapicker:results', datas);
    })

    const saveCallback = useCallback((datas = {}) => {
        emit('adminify:mediapicker:save', datas);
    })

    const emptyCallback = useCallback((datas = {}) => {
        emit('adminify:mediapicker:empty', datas);
    })

    const searchCallback = useCallback((datas = {}) => {
        emit('adminify:mediapicker:search', datas);
    })

    const hideCallback = useCallback((datas = {}) => {
        emit('adminify:mediapicker:hide', datas);
    })

    const addSelectionCallback = useCallback((datas = {}) => {
        emit('adminify:mediapicker:add', datas);
    })

    const removeSelectionCallback = useCallback((datas = {}) => {
        emit('adminify:mediapicker:remove', datas);
    })

    const showActiveMediaCallback = useCallback((datas = {}) => {
        emit('adminify:mediapicker:show_media', datas);
    })

    const hideActiveMediaCallback = useCallback((datas = {}) => {
        emit('adminify:mediapicker:hide_media', datas);
    })

    const onSelectionUpdatedCallback = useCallback((cb = (datas) => {},  useEffectDeps = []) => {

        useEffect(() => {
            on('adminify:mediapicker:selection_updated', cb);
            return () => {
                off('adminify:mediapicker:selection_updated', cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onResultsSelectionCallback = useCallback((cb = (datas) => {},  useEffectDeps = []) => {

        useEffect(() => {
            on('adminify:mediapicker:results', cb);
            return () => {
                off('adminify:mediapicker:results', cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onSaveSelectionCallback = useCallback((cb = (datas) => {},  useEffectDeps = []) => {

        useEffect(() => {
            on('adminify:mediapicker:save', cb);
            return () => {
                off('adminify:mediapicker:save', cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onHideCallback = useCallback((cb = (datas) => {},  useEffectDeps = []) => {

        useEffect(() => {
            on('adminify:mediapicker:hide', cb);
            return () => {
                off('adminify:mediapicker:hide', cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onShowCallback = useCallback((cb = (datas) => {},  useEffectDeps = []) => {

        useEffect(() => {
            on('adminify:mediapicker:show', cb);
            return () => {
                off('adminify:mediapicker:show', cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onUpdateCallback = useCallback((cb = (datas) => {},  useEffectDeps = []) => {

        useEffect(() => {
            on('adminify:mediapicker:update', cb);
            return () => {
                off('adminify:mediapicker:update', cb);
            }
        }, useEffectDeps)
        
    }, []);

    const onConfigCallback = useCallback((cb = (datas) => {},  useEffectDeps = []) => {
        useEffect(() => {
            on('adminify:mediapicker:config', cb);
            return () => {
                off('adminify:mediapicker:config', cb);
            }
        }, useEffectDeps)
        
    }, []);

    const isInSelectionCallback = useCallback((media) => {
        let isInSelection = false;
        selection.forEach((value, index, array) => {
            if(media.id === value.id) {
                isInSelection = true;
            }
        })


        return isInSelection;
    })

    let methods = {
        show : showCallback,
        hide : hideCallback,
        addSelection : addSelectionCallback,
        removeSelection : removeSelectionCallback,
        isInSelection : isInSelectionCallback,
        showActiveMedia : showActiveMediaCallback,
        hideActiveMedia : hideActiveMediaCallback,
        onSelectionUpdated : onSelectionUpdatedCallback,
        onResults : onResultsSelectionCallback,
        results : resultsCallback,
        save : saveCallback,
        onSave: onSaveSelectionCallback,
        onHide : onHideCallback,
        onShow : onShowCallback,
        onUpdate : onUpdateCallback,
        onConfig : onConfigCallback,
        config : configCallback,
        empty : emptyCallback,
        search : searchCallback
    }

    return methods;
}
