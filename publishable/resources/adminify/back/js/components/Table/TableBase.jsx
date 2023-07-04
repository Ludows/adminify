import React,{ useEffect } from 'react';
import Table from 'react-bootstrap/Table';
import TableDataList from '@/back/js/components/Table/TableDataList';
import TablePaginate from '@/back/js/components/Table/TablePaginate';
import useTranslations from '../../hooks/useTranslations';
export default function TableBase(props) {
    const { get } = useTranslations();

    useEffect(() => {
        console.log('Table.jsx onMounted', props);
    }, [])
    return <>
        <Table {...props}>
            <thead>
                <tr>
                    {props.datas.thead.map((headTitle, index) => {
                        return <th key={index}>{get('admin.table.th_cells.'+headTitle)}</th>
                    })}
                </tr>
            </thead>
            <TableDataList models={props.datas.paginator.data} data={props.datas} components={props.components} actions={props.actions} />
         </Table>
         <TablePaginate data={props.datas.paginator} />
    </>
}