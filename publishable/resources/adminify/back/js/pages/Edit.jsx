import useGlobalStore from '@/back/js/store/global';
import React from 'react';
import FormCard from '@/back/js/components/Cards/FormCard';

export default function Edit(props) {

    const appData = useGlobalStore((state) => state.getAppData);

    return <>
        <FormCard />
    </>
}