import React, { useEffect, useState, useRef } from 'react'

import Header from '../components/Header';
import Sidebar from '../components/Sidebar';
import TopPage from '../components/TopPage';
import Loader from '../components/Loader';
import Notifications from '../components/Notifications';
import Menu from '../components/Menu';
import usePageProps from '../hooks/usePageProps';
import { TailSpin } from 'react-loader-spinner';


import useAdminifyDefaults from '../hooks/useAdminifyDefaults';
import useAnimations from '../hooks/useAnimations';
import useRouterEvents from '../hooks/useRouterEvents';
import { AdminifyContext } from "../contexts/AdminifyContext";

import MediaPicker from '../components/Modal/MediaPicker';
import GlobalSearch from '../components/Modal/GlobalSearch';
import SidebarAdmin from '../components/Custom/SidebarAdmin';

export default function AdminLayout(component) {
    
    const [ready, setReadyState] = useState(false);

    const { on, off, emit, onRouterChange, onAjax, onFormSubmit  } = useAdminifyDefaults();
    const { get } = usePageProps();
    const { onStart, onBefore, onNavigate, onSuccess } = useRouterEvents();
    const { animate, register } = useAnimations();
    const rightCol = useRef({})

    onRouterChange()
    onAjax()
    onFormSubmit()

    emit('adminify:start', {});

    onBefore((e) => {
        animate('fadeout', [rightCol.current]);
    }, [])

    onSuccess((e) => {
        animate('fadein', [rightCol.current]);
    })

    // getHead();

    useEffect(() => {
        console.log('AdminLayout.jsx onMounted', component);
        
        if(component.children) {
            setReadyState(true);
            emit('adminify:ready', {});
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

    let adminMenu = get('adminMenu');

    let methodsToProvide = {
        on, 
        off, 
        emit,
        animate,
        registerAnimation :register
    }


    return  <AdminifyContext.Provider value={methodsToProvide}>
                <div className='container-fluid h-100 g-0'>
                    <div className='row h-100 g-0'>
                        <div className='col-12 bg-light'>
                            <Sidebar render={SidebarAdmin} className="sidebar-admin shadow-sm" children={ <Menu menu={adminMenu} /> }/>
                            <div ref={rightCol} className='content'>
                                <Header/>
                                <div className='p-4'>
                                    <TopPage/>
                                    {component.children}
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                <Notifications/>
                <MediaPicker/>
                <GlobalSearch/>
                <Loader center={true} className="h-100 position-fixed" children={ 
                        <TailSpin
                            height="100"
                                width="100"
                                radius="6"
                                color="#4fa94d"
                                secondaryColor=''
                                ariaLabel="revolving-dot-loading"
                                wrapperStyle={{}}
                                wrapperClass="loading_state"
                                visible={true}
                            /> } />
            </AdminifyContext.Provider>
}