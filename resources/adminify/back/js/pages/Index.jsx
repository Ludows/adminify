import TableListing from '@/back/js/components/Table/TableListing';
import usePageProps from '../hooks/usePageProps';
import React from 'react';

export default function Index(props) {

    const { get } = usePageProps();
    let table = get('table');
    

    return <TableListing datas={table} />
}