import React, { useState } from 'react';

import MediaLibrary from '../components/MediaPicker/MediaLibrary';
import useMediaPicker from '../hooks/useMediaPicker';
import ModalPreview from '../components/Modal/MediaPreview';
export default function Media(props) {
    
    const { onResults } = useMediaPicker({});

    let [datasFromMediaLibrary, setDatas] = useState({
        files : props.files,
        types : props.types,
        dates : props.dates,
        thumbs : props.thumbs
    })

    const handleDataForServer = (datas) => {
        console.log('datas', datas)
        setDatas(datas.result);
    }

    onResults(handleDataForServer);

    return <>
        <MediaLibrary usePreview={false} useMassDelete={true} datas={{...datasFromMediaLibrary}} />
        <ModalPreview />
    </>
}