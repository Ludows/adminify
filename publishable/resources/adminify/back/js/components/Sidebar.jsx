import React, { createRef, forwardRef } from 'react';
import useHelpers from '../hooks/useHelpers';

const Sidebar = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({});
    }
    const { createCustomRenderer } = useHelpers();
    
    let customRender = createCustomRenderer(null, props, ref);

    if(customRender) {
        return customRender;
    }
    
    return <div ref={ref} className='sticky-top sidebar'>
        {props.children}
    </div>
})

export default Sidebar;