import React, { useState, createRef, forwardRef } from 'react';
import useHelpers from '../hooks/useHelpers';
import useTranslations from '../hooks/useTranslations';

const Loader = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({})
    }  
    
    let defaults = {
        static : false,
        center : true,
        show : false,
        bg : 'white',
        txt : 'admin.loading_state'
    }

    let [loader, setLoader] = useState({...defaults, ...props});
    const { onLoader, createCustomRenderer } = useHelpers();
    const { get } = useTranslations();
    const defaults_classes = ['loader', 'd-flex', 'loader-adminify'];

    const handleLoadingState = (datas) => {
        console.log('onLoading...', datas);
        let merge = {...defaults, ...datas};
        setLoader((config) => merge);
    }
    onLoader(handleLoadingState, []);

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

    if(!loader.static) {
        attributes.className += ` is-fixed `;
    }

    if(loader.bg) {
        attributes.className += ` bg-${loader.bg} `;
    }
    
    
    if(!loader.show) {
        return null;
    }

    let customRender = createCustomRenderer(null, props, ref);

    if(customRender) {
        return customRender;
    }

    let state_loading_txt = get(loader.txt);

    return <div {...attributes}>
                <div className=''>
                       {/* {loader.body.render(loader, null)} */}
                       {props.children}
                        <div className='state_loading_txt mt-3'>{state_loading_txt}</div>
                </div>
            </div>
})
export default Loader;