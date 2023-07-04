import TableListing from '@/back/js/components/Table/TableListing';
import usePageProps from '../hooks/usePageProps';
import React from 'react';

export default function Index(props) {

    const { get } = usePageProps()
    

    return <>
        <TableListing datas={ get('table') } />
    </>
}