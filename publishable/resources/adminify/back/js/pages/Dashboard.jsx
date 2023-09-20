import React, { useEffect } from 'react';
import useGlobalStore from '../store/global';
export default function Dashboard({props}) {

    const appData = useGlobalStore((state) => state.getAppData);
    
    useEffect(() => {
        console.log('Dashboard.jsx onMounted', appData());
    }, [])

    return <>
        <div className='tata'>
            TATA
        </div>
    </>
}