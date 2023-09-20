import React, { useMemo, useEffect, createRef, forwardRef } from 'react';
import Toast from 'react-bootstrap/Toast';

import DefaultHeader from './Notify/DefaultHeader';
import DefaultBody from './Notify/DefaultBody';
import useHelpers from '../hooks/useHelpers';

const Notification = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({});
    }

    const { createCustomRenderer } = useHelpers();

    useEffect(() => {
        console.log('Notification.jsx mounted', props);
    }, [])

    let customRender = createCustomRenderer(null, props, ref); 

    if(customRender) {
        return customRender;
    }

    return <Toast {...props.toastProps}>
                {props.showHeader &&
                    <DefaultHeader data={props.data} {...props.headerProps}/>
                }
                {props.showBody &&
                    <DefaultBody data={props.data} {...props.bodyProps}/>
                }
            </Toast>
})

export default Notification;
