import React from 'react';
import Menu from './Menu';
import usePageProps from '../hooks/usePageProps';
export default function Sidebar({props}) {
    const { get } = usePageProps();
    
    return <>
        <Menu menu={ get('adminMenu') } />
    </>
}