import React, { useEffect, useCallback } from 'react';
import useEmitter from '../hooks/useEmitter';
import useAxios from '../hooks/useAxios';
import usePageProps from './usePageProps';
import { router } from '@inertiajs/react'
import { Head } from '@inertiajs/react'

export default function useAdminifyDefaults(fieldName) {

    const [on, off, emit] = useEmitter();
    const [createHttp, http] = useAxios();
    const { get, has } = usePageProps();

    const defaultFunctionRouterChanges = (e) => {
        console.log('adminify:router:change', e);
        let default_method = 'get';
        let default_url = window.location.href;
        let default_config_router = {
            onSuccess: (page) => {
                console.log('success', page);
                emit("adminify:datas:updated", page.props);
            },
            onError : (errors) => {
                emit("adminify:datas:errors", errors);
            }
        }
        let default_data = {}
        let hasKeysInForm = Object.keys(e.form).length > 0;

        if(hasKeysInForm || e.method) {
            default_method = hasKeysInForm ? e.form.formOptions.method.toLowerCase() : e.method;
        }

        if(hasKeysInForm || e.url) {
            default_url = hasKeysInForm ? e.form.formOptions.url : e.url;
        }

        if(e.data) {
            default_data = e.data;
        }

        console.log('useAdminifyDefaults.jsx defaultFunctionRouterChanges()', default_method, default_url, default_data)


        router[default_method](default_url, default_data, default_config_router);
    }

    const getHead = useCallback(() => {
        let hasSeo = has('seo');
        if(hasSeo) {
            let seo = get('seo');
            let seo_spl = seo.split('\n');
            console.log('seo split', seo_spl);
            return <Head>
                        {seo_spl.map((value, index, array) => {
                            if(value && value.length > 0) {
                                return value;
                            }
                        })}
                   </Head>
        }
    }, []);

    const defaultAjaxHandler = (datas) => {
        console.log('adminify:ajax', datas);
        let incoming_datas = datas;
        if(incoming_datas.method && incoming_datas.url) {
            createHttp(incoming_datas.url, {
                method: incoming_datas.method,
                data: incoming_datas.data ?? {},
                headers : { 'X-Inertia' : true },
                responseType : 'json',
                ...incoming_datas.config
            });

            http((error, datas) => {
                if(error) {
                    console.log('whoops', error);
                    emit("adminify:ajax:errors", error.response.data.errors);
                    return false;
                }

                emit("adminify:ajax:result", {
                    uuid : incoming_datas.data.uuid,
                    ...datas.data
                });

                // console.log('response', datas);
            })
        }
    }

    const defaultFormSubmit = (datas) => {
        console.log('adminify:submit', datas);

        if(datas.form && datas.data) {
            let form = datas.form;
            console.log(form.formOptions.method, form.formOptions.url, datas.data)

            createHttp(form.formOptions.url, {
                method: form.formOptions.method,
                data: datas.data,
                headers : { 'X-Inertia' : true },
                responseType : 'json',
            });

            http((error, datas) => {
                if(error) {
                    console.log('whoops', error);
                    emit("adminify:datas:errors", error.response.data.errors);
                    return false;
                }

                emit("adminify:submit:results", {
                    form : form,
                    data : datas.data
                });
            })
        }
    }

    let routerChangesCb = useCallback((overrideCb = null, useEffectDeps = []) => {
        useEffect(() => {
            let cb = typeof overrideCb == "function" ? overrideCb : defaultFunctionRouterChanges;

            on('adminify:router:change', cb);

            return () => {
                off("adminify:router:change", cb);
            }
        }, useEffectDeps)
    }, [])

    let onAjaxCb = useCallback((overrideCb = null, useEffectDeps = []) => {
        useEffect(() => {
            let cb = typeof overrideCb == "function" ? overrideCb : defaultAjaxHandler;
            on('adminify:ajax', cb);
            return () => {
                off("adminify:ajax", cb);
            }
        }, useEffectDeps)
    }, [])

    let onFormSubmitCb = useCallback((overrideCb = null, useEffectDeps = []) => {
        useEffect(() => {
            let cb = typeof overrideCb == "function" ? overrideCb : defaultFormSubmit;
            on('adminify:submit', cb);
            return () => {
                off("adminify:submit", cb);
            }
        }, useEffectDeps)
    }, [])

    let methods = {
        on,
        off,
        emit,
        getHead,
        createHttp, 
        http,
        onRouterChange: routerChangesCb,
        onAjax : onAjaxCb,
        onFormSubmit : onFormSubmitCb,
    }
    
    return methods;
}