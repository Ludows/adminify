import React,{ useEffect } from 'react';
import Table from 'react-bootstrap/Table';
import useGlobalStore from '@/back/js/store/global';
import TableDataList from '@/back/js/components/TableDataList';
import TablePaginate from '@/back/js/components/TablePaginate';
export default function TableBase(props) {
    const getTranslation = useGlobalStore(state => state.getTranslation);

    useEffect(() => {
        console.log('Table.jsx onMounted', props);
    }, [])
    return <>
        <Table {...props}>
            <thead>
                <tr>
                    {props.datas.thead.map((headTitle, index) => {
                        return <th key={index}>{getTranslation('admin.table.th_cells.'+headTitle)}</th>
                    })}
                </tr>
            </thead>
            <TableDataList data={props.datas} />
         </Table>
         <TablePaginate data={props.datas.paginator} />
    </>
}