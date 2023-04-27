import useGlobalStore from '@/back/js/store/global';
import React from 'react';
import Card from '@/back/js/components/Create/Card';

export default function Create(props) {

    const appData = useGlobalStore((state) => state.getAppData);

    return <>
        <Card />
    </>
}