import React, { useEffect } from 'react'

import Header from '../components/Header';
import Sidebar from '../components/Sidebar';
import TopPage from '../components/TopPage';
import useGlobalStore from '../store/global';

export default function AdminLayout(component) {
    
    const [ready, setReadyState] = useGlobalStore(
        (state) => [state.ready, state.setReadyState],
    )
    const [appData, setAppData] = useGlobalStore(
        (state) => [state.data, state.commit],
    )
    const getAppData = useGlobalStore((state) => state.getAppData);

    useEffect(() => {
        console.log('AdminLayout.jsx onMounted', component);
        if(component.children) {
                setAppData({data : component.children.props})
                setReadyState({ ready :  true})   
                console.log(getAppData('siteConfig'));         
        }
    }, [])

    if(!ready) {
        return <>
            TODO LOADING
        </>
    }

    return <>
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
    </>
}