import React, { useEffect } from 'react';
import usePageProps from '../hooks/usePageProps';
export default function Dashboard({props}) {

    
    useEffect(() => {
        console.log('Dashboard.jsx onMounted');
    }, [])

    return <>
        <div className='tata'>
            TATA
        </div>
    </>
}