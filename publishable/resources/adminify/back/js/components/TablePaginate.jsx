import React,{ useEffect } from 'react';
import Table from 'react-bootstrap/Table';
import useGlobalStore from '@/back/js/store/global';
import Pagination from 'react-bootstrap/Pagination';

export default function TablePaginate(props) {
    const getTranslation = useGlobalStore(state => state.getTranslation);

    useEffect(() => {
        console.log('TablePaginate.jsx onMounted', props);
    }, [])
    return <>
        <Pagination>
            <Pagination.Item active={true}>{1}</Pagination.Item>
        </Pagination>
    </>
}