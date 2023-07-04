import React, { useEffect } from 'react';
import FloatingLabel from 'react-bootstrap/FloatingLabel';
import Form from 'react-bootstrap/Form';
import useHelpers from '../../hooks/useHelpers';
import useTranslations from '../../hooks/useTranslations';

export default function TableStatuses(props) {
    const { get } = useTranslations();
    const { tableSearch } = useHelpers();

    const doSearch = (e) => {
        let input = e.target;
        tableSearch({
            status : parseInt(input.value.trim()),
        })
    }

    useEffect(() => {
        console.log('TableStatuses.jsx onMounted', props);
    }, [])

    return <>
            <FloatingLabel controlId="floatingSelect" label={get('admin.table.modules.statuses.select_status')}>
                <Form.Select onChange={doSearch} aria-label="Floating label select example">
                    {props.datas.statuses.map((status, index) => {
                        return <option value={status.id}>{get('admin.table.modules.statuses.'+status.name)}</option>
                    })}
                    
                </Form.Select>
            </FloatingLabel>
    </>
}