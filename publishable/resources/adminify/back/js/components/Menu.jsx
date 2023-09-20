import React, { useEffect, useMemo } from 'react';
import { Link } from '@inertiajs/react'

export default function Menu(props) {

    let menu = useMemo(() => props.menu, [props.menu]);
    let menuKeys = useMemo(() => Object.keys(menu), [props.menu]);

    useEffect(() => {
        console.log('Menu.jsx onMounted', menuKeys);
    }, [])
    
    return <>
        <ul className="nav flex-column">
            {menuKeys.map((menuKey, index) => {
                return <li key={index} className="nav-item">
                    <Link href={menu[menuKey].url} className='nav-link'>{ menu[menuKey].label }</Link> 
                </li>
            })}
        </ul>
    </>
}