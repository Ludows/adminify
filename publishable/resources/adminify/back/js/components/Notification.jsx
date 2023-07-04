import React, { useMemo, useEffect } from 'react';
import Toast from 'react-bootstrap/Toast';

import DefaultHeader from './Notify/DefaultHeader';
import DefaultBody from './Notify/DefaultBody';

export default function Notification(props) {

    let bodyComponent = useMemo(() => props.body ?? null, [props]);
    let headerComponent = useMemo(() => props.header ?? null, [props]);

    useEffect(() => {
        console.log('Notification.jsx mounted', props);
    }, [])

    return <>
        <Toast
          {...props.toastProps}
        >
            {props.showHeader &&
                <>
                    {headerComponent ? <headerComponent data={props.data} {...props.headerProps}/> : <DefaultHeader data={props.data} {...props.headerProps}/>}
                </>
            }
            {props.showBody &&
                <>
                    {bodyComponent ? <bodyComponent data={props.data} {...props.bodyProps}/> : <DefaultBody data={props.data} {...props.bodyProps}/>}
                </>
            }
        </Toast>
    </>
}
