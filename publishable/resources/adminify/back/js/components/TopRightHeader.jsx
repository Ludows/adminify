import React, { useEffect, createRef, forwardRef } from 'react';
import DropdownLang from './Dropdowns/DropdownLang';
import DropdownUser from './Dropdowns/DropdownUser';
import useHelpers from '../hooks/useHelpers';

const TopRightHeader = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({});
    }
    
    useEffect(() => {
        console.log('TopRightHeader.jsx onMounted');
    }, [])

    const { createCustomRenderer } = useHelpers();

    let customRender = createCustomRenderer(null, props, ref);

    if(customRender) {
        return customRender;
    }

    return <ul ref={ref} className="navbar-nav align-items-center d-none d-md-flex">
                <DropdownLang/>
                <DropdownUser/>
            </ul>
})
export default TopRightHeader;