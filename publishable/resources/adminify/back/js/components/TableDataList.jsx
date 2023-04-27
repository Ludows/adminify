import React,{ useEffect } from 'react';
import useGlobalStore from '@/back/js/store/global';

export default function TableDataList(props) {
    const getTranslation = useGlobalStore(state => state.getTranslation);

    useEffect(() => {
        console.log('TableDataList.jsx onMounted', props);
    }, [])
    return <>
        <tbody>
            
                {props.data.count > 0 &&
                    (() => {
                        for (let i = 0; i < props.data.count; i++) {
                            <tr>
                                {props.data.thead.map((content, index) => {
                                    return <td key={index}>
                                        {props.data.datas[content][i].value}
                                    </td>
                                })}
                            </tr>
                        }
                    })()
                }

                {props.data.count == 0 && 
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