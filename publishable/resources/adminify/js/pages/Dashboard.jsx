import React, { useEffect } from 'react';
export default function Dashboard({props}) {
    
    useEffect(() => {
        console.log('Dashboard.jsx onMounted', props);
    }, [])

    return <>
        <div className='tata'>
            TATA
        </div>
    </>
}