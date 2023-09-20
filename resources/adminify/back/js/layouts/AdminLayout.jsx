import React, { useEffect, useState } from 'react'

import Header from '../components/Header';
import Sidebar from '../components/Sidebar';
import TopPage from '../components/TopPage';
import Loader from '../components/Loader';
import Notifications from '../components/Notifications';

import useAdminifyDefaults from '../hooks/useAdminifyDefaults';
import { EmitterContext } from "../contexts/EmitterContext";

import MediaPicker from '../components/Modal/MediaPicker';
import GlobalSearch from '../components/Modal/GlobalSearch';

export default function AdminLayout(component) {
    
    const [ready, setReadyState] = useState(false);

    // const [on, off, emit] = useEmitter();
    // const [createHttp, http] = useAxios();
    const { on, off, emit, onRouterChange, onAjax, onFormSubmit, getHead  } = useAdminifyDefaults();

    onRouterChange()
    onAjax()
    onFormSubmit()

    getHead();

    useEffect(() => {
        console.log('AdminLayout.jsx onMounted', component);
        if(component.children) {
            setReadyState(true);
        }

        return () => {
            setReadyState(false) ;
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
                <div className='row h-100 g-0'>
                    <div className='col-12 col-lg-3 d-none d-lg-block'>
                        <Sidebar/>
                    </div>
                    <div className='col-12 col-lg-9 bg-primary'>
                        <div className='px-4 pb-4'>
                            <Header/>
                            <TopPage/>
                            {component.children}
                        </div>
                    </div>
                </div>
            </div>
            
            <Notifications/>
            <MediaPicker/>
            <GlobalSearch/>
            <Loader className="h-100 position-fixed"/>
        </EmitterContext.Provider>
    </>
}