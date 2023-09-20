import React, { createRef, forwardRef } from 'react';
import Menu from './Menu';
import usePageProps from '../hooks/usePageProps';
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

    const { get } = usePageProps();
    let adminMenu = get('adminMenu');
    
    return <div ref={ref} className='sidebar sticky-top'>
        <Menu menu={adminMenu} />
    </div>
})

export default Sidebar;