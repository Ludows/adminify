
import React, {useCallback, useRef, useContext, useEffect} from 'react';
import { AdminifyContext } from "../contexts/AdminifyContext";
import { v4 as uuidv4 } from 'uuid';
import Swal from 'sweetalert2';

import Route from "../libs/Route";

export default function useHelpers() {

    const {on, off, emit} = useContext(AdminifyContext);

    // console.log([on, off, emit])
    
    const notifyConfig = useRef({
        toastProps : {
            bg : 'success',
            className : 'text-white'
        },
        headerProps : {
            closeLabel : '',
            closeButton : false
        },
        bodyProps : {},
        useTimer : true,
        showHeader : false,
        showBody : true,
        data : {},
        time : 3000
    });

    const loaderConfig = useRef({
        show: false,
    });

    const defaultAjaxConfig = useRef({
        method : 'get',
        data : {},
        url : '',
    });

    const defaultCustomRenderer = (props, ref) => {
        let isEmpty = emptyCb(props.render);
        if(isEmpty) {
            return null;
        }
        let CustomComponent = props.render;
        return <CustomComponent ref={ref} {...props} />
    }

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

    let uuidCb = useCallback((prepend = '') => {
        return prepend+uuidv4();
    }, [])

    let createCustomRendererCb = useCallback((overrideCb = null, props = {}, ref = null) => {
        let test = typeof overrideCb === "function";
        let useCustomRender = !emptyCb(props) && props.hasOwnProperty('render');

        if(!useCustomRender) {
            return null;
        }

        if(test && useCustomRender) {
            return overrideCb(props, ref);
        }
        
        return defaultCustomRenderer(props, ref);
    }, [])

    let swalCb = useCallback((swalConfig = {}, swalResultCb = (error, result) => {},  extraDatas = {} ) => {
        Swal.fire(swalConfig)
        .then((result) => swalResultCb(null, result, extraDatas) )
        .catch((error) => { swalResultCb(error, null, extraDatas) })
    }, [])

    let emptyCb = useCallback((n) => {
        return !(!!n ? typeof n === 'object' ? Array.isArray(n) ? !!n.length : !!Object.keys(n).length : true : false);
    }, [])

    let defaultValueFormater = (items) => {
        let return_items = null;

        if(items) {
          let isArray = items instanceof Array;
          if(isArray) {
            return_items = [];
    
            items.forEach((model, index, array) => {
              return_items.push( model.id );
            })
          }
          else {
            return_items = items;
          }
        }
    
        return return_items;
    }

    let formatValueCb = useCallback((items, overrideCb = null) => {
        let test = typeof overrideCb === "function";

        if(test) {
            return overrideCb(items);
        }
        
        return defaultValueFormater(items);
    }, []) 

    let modalCb = useCallback((name = '', opts = {}) => {
        let final = {
            ...{
                show : false
            },
            ...opts,
        }


        emit('adminify:modal:'+name, final);
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
        formatValue: formatValueCb,
        fire : fireCb,
        ajax : ajaxCb,
        uuid : uuidCb,
        empty: emptyCb,
        createCustomRenderer : createCustomRendererCb,
        onAjaxResult : onAjaxResultCb,
        onAjaxErrors : onAjaxErrorCb,
        randomNumber : randomNumberCb,
        submitResults: submitResultsCb,
        errors: errorsCb,
        swal : swalCb,
        modal : modalCb,
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
