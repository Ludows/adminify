import React, { useEffect } from 'react';
import DropdownLang from './DropdownLang';
import DropdownUser from './DropdownUser';
export default function TopRightHeader(props) {

    useEffect(() => {
        console.log('TopRightHeader.jsx onMounted');
    }, [])

    DropdownUser

    return <>
        <ul className="navbar-nav align-items-center d-none d-md-flex">
            <DropdownLang/>
            <DropdownUser/>
        </ul>
    </>
}