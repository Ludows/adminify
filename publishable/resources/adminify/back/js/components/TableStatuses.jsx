import React, { useEffect } from 'react';
import FloatingLabel from 'react-bootstrap/FloatingLabel';
import Form from 'react-bootstrap/Form';
import useGlobalStore from '@/back/js/store/global';

export default function TableStatuses(props) {
    const getTranslation = useGlobalStore(state => state.getTranslation);

    useEffect(() => {
        console.log('TableStatuses.jsx onMounted', props);
    }, [])

    return <>
            <FloatingLabel controlId="floatingSelect" label={getTranslation('admin.table.modules.statuses.select_status')}>
                <Form.Select aria-label="Floating label select example">
                    {props.datas.statuses.map((status, index) => {
                        return <option value={status.id}>{getTranslation('admin.table.modules.statuses.'+status.name)}</option>
                    })}
                    
                </Form.Select>
            </FloatingLabel>
    </>
}