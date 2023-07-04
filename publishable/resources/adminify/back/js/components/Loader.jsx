import React, { useState } from 'react';
import useHelpers from '../hooks/useHelpers';
export default function Loader(props) {

    let defaults = {
        static : false,
        center : false
    }
    let [loader, setLoader] = useState({...defaults, ...props});
    const { onLoader } = useHelpers();
    const defaults_classes = ['loader', 'd-flex'];

    const handleLoadingState = (datas) => {
        console.log('onLoading...', datas.body);
        setLoader(datas);
    }
    onLoader(handleLoadingState);

    let attributes = {
        className : 'loader d-flex',
        ...props
    }

    if(!attributes.className.includes('loader')) {
        attributes.className += ` ${defaults_classes.join(' ')}`;
    }
    if(loader.center) {
        attributes.className += ` align-items-center justify-content-center`;
    }
    


    return <>
        {loader.show &&
            <div {...attributes}>
                <div className=''>
                    <>
                        {loader.body.render(loader, null)}
                    </>
                </div>
            </div>
            
        }
    </>
}