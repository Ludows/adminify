import React, { useEffect } from 'react';
import TopLeftHeader from './TopLeftHeader';
import TopRightHeader from './TopRightHeader';
export default function Header({props}) {

    useEffect(() => {
        console.log('Header.jsx onMounted');
    }, [])

    return <>
       <nav className="navbar navbar-top navbar-expand-md bg-gradient-primary" id="navbar-main">
            <div className="container-fluid">
              <TopLeftHeader />
              <TopRightHeader />
            </div>
        </nav>
    </>
}