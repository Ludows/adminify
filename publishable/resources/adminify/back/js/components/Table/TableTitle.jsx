import React, { useEffect } from 'react';
export default function TableTitle(props) {

    useEffect(() => {
        console.log('TableTitle.jsx onMounted', props);
    }, [])
    return <div className='table-title text-dark h5 me-3'>
        {props.global.name}
    </div>
}