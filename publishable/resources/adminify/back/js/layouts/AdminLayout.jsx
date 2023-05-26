import React, { useEffect, createContext } from 'react'

import Header from '../components/Header';
import Sidebar from '../components/Sidebar';
import TopPage from '../components/TopPage';
import Notifications from '../components/Notifications';
import useGlobalStore from '../store/global';
import { router } from '@inertiajs/react'

import useEmitter from '../hooks/useEmitter';
import useAxios from '../hooks/useAxios';
import Route from '@/commons/js/Route';
// import { useEventListener } from 'usehooks-ts'
import { EmitterContext } from "../contexts/EmitterContext";

import MediaPicker from '../components/Modal/MediaPicker';

export default function AdminLayout(component) {
    
    const [ready, setReadyState] = useGlobalStore(
        (state) => [state.ready, state.setReadyState],
    )
    const [appData, setAppData] = useGlobalStore(
        (state) => [state.data, state.commit],
    )

    const [translations, setTranslations] = useGlobalStore(
        (state) => [state.translations, state.setTranslations],
    )
    const getAppData = useGlobalStore((state) => state.getAppData);

    const [on, off, emit] = useEmitter();
    const [createHttp, http] = useAxios();

    const routerChangesHandler = (e) => {
        console.log('adminify:router:change', e);
        let default_method = 'get';
        let default_url = window.location.href;
        let default_config_router = {
            onSuccess: (page) => {
                console.log('success', page);
                setAppData({data : page.props})
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

        console.log('AdminLayout.jsx routerChangesHandler()', default_method, default_url, default_data)


        router[default_method](default_url, default_data, default_config_router);

    }

    const basicAjaxHandler = (datas) => {
        console.log('adminify:ajax', datas);
        if(datas.method && datas.url) {
            createHttp(datas.url, {
                method: datas.method,
                data: datas.data ?? {},
                headers : { 'X-Inertia' : true },
                responseType : 'json',
                timeout: 10000,
                ...datas.config
            });

            http((error, datas) => {
                if(error) {
                    console.log('whoops', error);
                    emit("adminify:datas:errors", error.response.data.errors);
                    return false;
                }

                console.log('response', datas);
            })
        }
    }

    const formSubmitHandler = (datas) => {
        console.log('adminify:submit', datas);
        if(datas.form && datas.data) {
            
            console.log(datas.form.formOptions.method, datas.form.formOptions.url, datas.data)

            createHttp(datas.form.formOptions.url, {
                method: datas.form.formOptions.method,
                data: datas.data,
                headers : { 'X-Inertia' : true },
                responseType : 'json',
                timeout: 10000
            });

            http((error, datas) => {
                if(error) {
                    console.log('whoops', error);
                    emit("adminify:datas:errors", error.response.data.errors);
                    return false;
                }

                console.log('response', datas);
            })
        }
    }

    useEffect(() => {
        console.log('AdminLayout.jsx onMounted', component);
        if(component.children) {
                setAppData({data : component.children.props})
                setTranslations({translations: window['messages_'+ document.documentElement.getAttribute('lang') ]});

                on('adminify:router:change', routerChangesHandler)
                on('adminify:submit', formSubmitHandler)
                on('adminify:ajax', basicAjaxHandler)

                setReadyState({ ready :  true})   
        }

        return () => {
            setReadyState({ ready :  false})  
            off('adminify:router:change', routerChangesHandler);
            off('adminify:submit', formSubmitHandler);
            off('adminify:ajax', basicAjaxHandler);
        }
    }, [])

    if(!ready) {
        return <>
            TODO LOADING
        </>
    }

    return <>
        <EmitterContext.Provider value={[on, off, emit]}>
            <div className='container-fluid h-100 g-0'>
                <div className='row h-100'>
                    <div className='col-12 col-lg-3 d-none d-lg-block'>
                        <Sidebar/>
                    </div>
                    <div className='col-12 col-lg-9 bg-primary'>
                        <Header/>
                        <TopPage/>
                        {component.children}
                        <Notifications/>
                    </div>
                </div>
            </div>
            
            <MediaPicker/>
        </EmitterContext.Provider>
    </>
}