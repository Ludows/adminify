import React, { useEffect, forwardRef, createRef } from 'react';
import TopLeftHeader from './TopLeftHeader';
import TopRightHeader from './TopRightHeader';
import useHelpers from '../hooks/useHelpers';

const Header = forwardRef((props, ref) => {

    useEffect(() => {
        console.log('Header.jsx onMounted');
    }, [])

    if(!ref) {
        ref = createRef({});
    }
    
    const { createCustomRenderer } = useHelpers();
    
    let customRender = createCustomRenderer(null, props, ref);

    if(customRender) {
        return customRender;
    }

    return <nav ref={ref} className="navbar navbar-top navbar-expand-md bg-gradient-primary" id="navbar-main">
                <div className="container-fluid">
                <TopLeftHeader />
                <TopRightHeader />
                </div>
            </nav>
});

export default Header;