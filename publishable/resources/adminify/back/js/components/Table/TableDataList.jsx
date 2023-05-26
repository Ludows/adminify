import React,{ useEffect, useContext, useState } from 'react';
import useGlobalStore from '@/back/js/store/global';
import Cell from '@/back/js/components/Table/Cell';
import { EmitterContext } from "@/back/js/contexts/EmitterContext";

export default function TableDataList(props) {
    const getTranslation = useGlobalStore(state => state.getTranslation);
    const [on, off, emit] = useContext(EmitterContext);
    const [rows, setRows] = useState(props.data.rows ?? []);

    const handleResults = (datas) => {
        setRows(datas.result.rows);
    }

    useEffect(() => {
        console.log('TableDataList.jsx onMounted', props);
        on('adminify:table:results', handleResults);

        return () => {
            off('adminify:table:results', handleResults);
        }
    }, [])
    return <>
        <tbody>
            
                {rows.length > 0 &&
                    <>
                        {rows.map((row, index) => {
                            let component_keys = Object.keys(row);
                            return <tr key={index}>
                                {component_keys.map((value, index, array) => {
                                    if ( props.components[value]) {
                                        let Component =  props.components[value];
                                        if(value == 'actions') {
                                            return <Component data={row[value]} actions={props.actions}/>   
                                        }
                                        else {
                                            return <Component data={row[value]}/>   
                                        }                                                                             
                                    }
                                    else {
                                        return <Cell data={row[value]} />
                                    }
                                })}
                            </tr>
                        })}
                    </>   
                }

                {rows.length == 0 && 
                    <tr>
                        <td>
                            {getTranslation('admin.table.modules.listings.no_datas')}
                        </td>
                    </tr>
                }
                
                {/* {props.datas.datas.map((content, index) => {
                    return <td key={index}>{content}</td>
                })} */}
            
        </tbody>
    </>
}