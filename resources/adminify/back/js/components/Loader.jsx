import React, { useState, createRef, forwardRef } from 'react';
import useHelpers from '../hooks/useHelpers';
import { RevolvingDot } from 'react-loader-spinner';

const Loader = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({})
    }  
    
    let defaults = {
        static : false,
        center : false,
        show : false,
    }

    let [loader, setLoader] = useState({...defaults, ...props});
    const { onLoader, createCustomRenderer } = useHelpers();
    const defaults_classes = ['loader', 'd-flex'];

    const handleLoadingState = (datas) => {
        console.log('onLoading...', datas);
        setLoader(datas);
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
    
    if(!loader.show) {
        return null;
    }

    let customRender = createCustomRenderer(null, props, ref);

    if(customRender) {
        return customRender;
    }

    return <div {...attributes}>
                <div className=''>
                       {/* {loader.body.render(loader, null)} */}
                       <RevolvingDot
                            height="100"
                            width="100"
                            radius="6"
                            color="#4fa94d"
                            secondaryColor=''
                            ariaLabel="revolving-dot-loading"
                            wrapperStyle={{}}
                            wrapperClass=""
                            visible={true}
                            {...props}
                        />
                </div>
            </div>
})
export default Loader;