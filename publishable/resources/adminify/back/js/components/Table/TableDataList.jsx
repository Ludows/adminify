import React,{ useState } from 'react';
import Cell from '../../components/Table/Cell';
import useHelpers from '../../hooks/useHelpers';
import useTranslations from '../../hooks/useTranslations';

export default function TableDataList(props) {
    const { get } = useTranslations();
    const [rows, setRows] = useState(props.data.rows ?? []);
    const [models, setModels] = useState(props.models ?? []);
    const { onTableResults } = useHelpers();

    const handleResults = (datas) => {
        console.log(datas)
        setModels(datas.result.paginator.data);
        setRows(datas.result.rows);
    }

    onTableResults(handleResults, [])

    return <>
        <tbody>
            
                {rows.length > 0 &&
                    <>
                        {rows.map((row, rIndex) => {
                            let component_keys = Object.keys(row);
                            return <tr key={rIndex}>
                                {component_keys.map((value, index, array) => {
                                    if ( props.components[value]) {
                                        let Component =  props.components[value];
                                        if(value == 'actions') {
                                            return <Component key={index} model={models[rIndex]} data={row[value]} actions={props.actions}/>   
                                        }
                                        else {
                                            return <Component key={index} model={models[rIndex]} data={row[value]}/>   
                                        }                                                                             
                                    }
                                    else {
                                        return <Cell key={index} model={models[rIndex]} data={row[value]} />
                                    }
                                })}
                            </tr>
                        })}
                    </>   
                }

                {rows.length == 0 && 
                    <tr>
                        <td colSpan={props.data.thead.length}>
                            {get('admin.table.modules.listings.no_datas')}
                        </td>
                    </tr>
                }
                
                {/* {props.datas.datas.map((content, index) => {
                    return <td key={index}>{content}</td>
                })} */}
            
        </tbody>
    </>
}