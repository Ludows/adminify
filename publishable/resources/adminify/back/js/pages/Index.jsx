import TableListing from '@/back/js/components/Table/TableListing';
import useGlobalStore from '@/back/js/store/global';
import React from 'react';

export default function Index(props) {

    const appData = useGlobalStore((state) => state.getAppData);

    return <>
        <TableListing datas={ appData('table') } />
    </>
}