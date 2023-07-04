import React, { useEffect, createContext } from 'react'

import Header from '../components/Header';
import Sidebar from '../components/Sidebar';
import TopPage from '../components/TopPage';
import Loader from '../components/Loader';
import Notifications from '../components/Notifications';
import useGlobalStore from '../store/global';
import { router } from '@inertiajs/react'

import useEmitter from '../hooks/useEmitter';
import useAxios from '../hooks/useAxios';
import { EmitterContext } from "../contexts/EmitterContext";

import MediaPicker from '../components/Modal/MediaPicker';

export default function AdminLayout(component) {
    
    const [ready, setReadyState] = useGlobalStore(
        (state) => [state.ready, state.setReadyState],
    )

    const [on, off, emit] = useEmitter();
    const [createHttp, http] = useAxios();

    const routerChangesHandler = (e) => {
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

        console.log('AdminLayout.jsx routerChangesHandler()', default_method, default_url, default_data)


        router[default_method](default_url, default_data, default_config_router);

    }

    const basicAjaxHandler = (datas) => {
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

    const formSubmitHandler = (datas) => {
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

    useEffect(() => {
        console.log('AdminLayout.jsx onMounted', component);
        if(component.children) {

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
            LOADING
            {/* <EmitterContext.Provider value={[on, off, emit]}>
                <Loader static={true} />
            </EmitterContext.Provider> */}
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
                    </div>
                </div>
            </div>
            
            <Notifications/>
            <MediaPicker/>
            <Loader className="h-100 position-fixed"/>
        </EmitterContext.Provider>
    </>
}