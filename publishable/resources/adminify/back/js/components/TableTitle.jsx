import React, { useEffect } from 'react';
export default function TableTitle(props) {

    useEffect(() => {
        console.log('TableTitle.jsx onMounted', props);
    }, [])
    return <>
        {props.global.name}
    </>
}