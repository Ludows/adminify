
import React, {useCallback, useRef, useContext, useEffect} from 'react';
import { EmitterContext } from "@/back/js/contexts/EmitterContext";
import { v4 as uuidv4 } from 'uuid';
import Swal from 'sweetalert2';

import DefaultLoader from '../components/DefaultLoader';
import Route from "../../../commons/js/Route";

export default function useHelpers() {

    const [on, off, emit] = useContext(EmitterContext);

    // console.log([on, off, emit])
    
    const notifyConfig = useRef({
        toastProps : {
            bg : 'light'
        },
        headerProps : {
            closeLabel : '',
            closeButton : false
        },
        bodyProps : {},
        useTimer : true,
        showHeader : true,
        showBody : true,
        data : {},
        title: null,
        body : null,
        time : 10000
    });

    const loaderConfig = useRef({
        show: false,
        body : DefaultLoader,
    });

    const defaultAjaxConfig = useRef({
        method : 'get',
        data : {},
        url : '',
    });

    let navigateCb = useCallback((object) => {
        let defaults = {
            form: {},
            data : {},
            method : 'get',
            url : ''
        };
        let final = {...defaults, ...object};
        emit('adminify:router:change', final);
    }, [])

    let notifyCb = useCallback((object) => {
        let uuidObject = {  uuid : 'notify-'+uuidv4(),  }
        let final = {...notifyConfig.current, ...uuidObject, ...object};
        emit('adminify:notify', final);
    }, [])

    let tableSearchCb = useCallback((object) => {
        emit('adminify:table:search', object);
    }, [])

    let routeCb = useCallback((name = '', params = {}) => {
       return Route(name, params);
    }, [])

    let tableResultsCb = useCallback((object) => {
        let defauts = {
            payload : {},
            result : {}
        }
        let final = {...defauts, ...object};
        emit('adminify:table:results', final);
    }, [])

    let onTableSearchCb = useCallback((fn = (datas) => {}, useEffectDeps = []) => {
        useEffect(() => {
            on('adminify:table:search', fn);
            return () => {
                off('adminify:table:search', fn);
            }
        }, useEffectDeps)
    }, [])
    
    let loaderCb = useCallback((object) => {
        let final = {...loaderConfig.current, ...object};
        emit('adminify:loader', final);
    }, [])

    let submitCb = useCallback((object) => {
        let defaults = {
            loader : loaderCb,
            notify : notifyCb,
            form : {},
            data : {}
        }
        let final = {...defaults, ...object};
        emit('adminify:submit', final);
    }, [])

    let submitResultsCb = useCallback((object) => {
        let final = {...object};
        emit('adminify:submit:results', final);
    }, [])

    let errorsCb = useCallback((object) => {
        let final = {...object};
        emit('adminify:datas:errors', final);
    }, [])

    let NotifyHookCb = useCallback((fn = (datas) => {}, useEffectDeps = []) => {
        useEffect(() => {
            on('adminify:notify', fn);
            return () => {
                off('adminify:notify', fn);
            }
        }, useEffectDeps)
    }, [])

    let onLoaderCb = useCallback((fn = (datas) => {}, useEffectDeps = []) => {
        useEffect(() => {
            on('adminify:loader', fn);
            return () => {
                off('adminify:loader', fn);
            }
        }, useEffectDeps)
    }, [])

    let onTableResultsCb = useCallback((fn = (datas) => {}, useEffectDeps = []) => {
        useEffect(() => {
            on('adminify:table:results', fn);
            return () => {
                off('adminify:table:results', fn);
            }
        }, useEffectDeps)
    }, [])

    let onSubmitResultsCb = useCallback((fn = (datas) => {}, useEffectDeps = []) => {
        useEffect(() => {
            on('adminify:submit:results', fn);
            return () => {
                off('adminify:submit:results', fn);
            }
        }, useEffectDeps)
    }, [])

    let onAppUpdatedCb = useCallback((fn = (datas) => {}, useEffectDeps = []) => {
        useEffect(() => {
            on('adminify:datas:updated', fn);
            return () => {
                off('adminify:datas:updated', fn);
            }
        }, useEffectDeps)
    }, [])

    let onErrorsCb = useCallback((fn = (datas) => {}, useEffectDeps = []) => {
        useEffect(() => {
            on('adminify:datas:errors', fn);
            return () => {
                off('adminify:datas:errors', fn);
            }
        }, useEffectDeps)
    }, [])

    let onEventCb = useCallback((eventName = '', fn = (datas) => {}, useEffectDeps = []) => {
        useEffect(() => {
            on(eventName, fn);
            return () => {
                off(eventName, fn);
            }
        }, useEffectDeps)
    }, [])

    let fireCb = useCallback((eventName = '', object = {}) => {
        let final = {...object};
        emit(eventName, final);
    }, [])

    let filterObjectsCb = useCallback((obj, callback) => {
        return Object.fromEntries(Object.entries(obj).
        filter(([key, val]) => callback(val, key)));
    }, [])

    let randomNumberCb = useCallback((number = 10) => {
        const typedArray = new Uint8Array(number);
        const randomValues = window.crypto.getRandomValues(typedArray);
        return parseInt( randomValues.join('') );
    }, [])

    let ajaxCb = useCallback((config = {}) => {
        let mergeConfig = {
            ...defaultAjaxConfig.current,
            ...config
        }
        emit('adminify:ajax', mergeConfig);
    }, [])

    let onAjaxResultCb = useCallback((fn = (datas) => {}, useEffectDeps = []) => {
        useEffect(() => {
            on('adminify:ajax:result', fn);
            return () => {
                off('adminify:datas:result', fn);
            }
        }, useEffectDeps)
    }, [])

    let onAjaxErrorCb = useCallback((fn = (datas) => {}, useEffectDeps = []) => {
        useEffect(() => {
            on('adminify:ajax:errors', fn);
            return () => {
                off('adminify:datas:errors', fn);
            }
        }, useEffectDeps)
    }, [])

    let uuidCb = useCallback(() => {
        return uuidv4();
    }, [])

    let swalCb = useCallback((swalConfig = {}, swalResultCb = (error, result) => {}) => {
        Swal.fire(swalConfig)
        .then((result) => swalResultCb(null, result) )
        .catch((error) => { swalResultCb(error, null) })
    }, [])
    
    let methods = {
        navigate : navigateCb,
        notify : notifyCb,
        onNotify : NotifyHookCb,
        onLoader : onLoaderCb,
        loader : loaderCb,
        submit : submitCb,
        route : routeCb,
        event: onEventCb,
        fire : fireCb,
        ajax : ajaxCb,
        uuid : uuidCb,
        onAjaxResult : onAjaxResultCb,
        onAjaxErrors : onAjaxErrorCb,
        randomNumber : randomNumberCb,
        submitResults: submitResultsCb,
        errors: errorsCb,
        swal : swalCb,
        onErrors : onErrorsCb,
        onSubmitResults : onSubmitResultsCb,
        tableSearch : tableSearchCb,
        onTableSearch: onTableSearchCb,
        onTableResults : onTableResultsCb,
        tableResults : tableResultsCb,
        onAppUpdated : onAppUpdatedCb,
        filterObjects : filterObjectsCb
    }

    return methods;
}
