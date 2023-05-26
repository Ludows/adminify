import React, { useEffect, useMemo, useContext } from 'react';
import { Link } from '@inertiajs/react'
import { EmitterContext } from "../contexts/EmitterContext";

export default function Menu(props) {

    let menu = useMemo(() => props.menu, [props.menu]);
    let menuKeys = useMemo(() => Object.keys(menu), [props.menu]);
    const [on, off, emit] = useContext(EmitterContext);

    useEffect(() => {
        console.log('Menu.jsx onMounted', menuKeys);
    }, [])

    const handleVisit = (menuItem) => {

        let defaults = {
            form : {},
            data: {},
            method: 'get'
        }

        let obj = {
            ...menuItem,
            ...defaults
        }

        emit('adminify:router:change', obj);
    }
    
    return <>
        <ul className="nav flex-column">
            {menuKeys.map((menuKey, index) => {
                return <li key={index} className="nav-item">
                    {/* <Link replace href={menu[menuKey].url} className='nav-link'>{ menu[menuKey].label }</Link>  */}
                    <button onClick={() => { handleVisit(menu[menuKey]) }} className='nav-link bg-transparent border-0'>{ menu[menuKey].label }</button> 
                </li>
            })}
        </ul>
    </>
}