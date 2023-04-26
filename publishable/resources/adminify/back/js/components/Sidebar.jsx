import React from 'react';
import Menu from './Menu';
import useGlobalStore from '../store/global';
export default function Sidebar({props}) {
    const getData = useGlobalStore(state => state.getAppData);
    return <>
        <Menu menu={ getData('adminMenu') } />
    </>
}