import React, { useEffect } from 'react'

import Header from '../components/Header';
import Sidebar from '../components/Sidebar';
import TopPage from '../components/TopPage';

export default function AdminLayout({props, children}) {

    useEffect(() => {
        console.log('AdminLayout.jsx onMounted', props);
    }, [])

    return <>
        <div className='container-fluid h-100 g-0'>
            <div className='row h-100'>
                <div className='col-12 col-lg-3 d-none d-lg-block'>
                    <Sidebar/>
                </div>
                <div className='col-12 col-lg-9 bg-primary'>
                    <Header/>
                    <TopPage/>
                    {children}
                </div>
            </div>
        </div>
    </>
}