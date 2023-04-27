import React, { useMemo } from 'react';
import FormElement from '@/back/js/components/FormElement';
import Form from 'react-bootstrap/Form';

export default function BaseForm(props) {

    const fields = useMemo(() => props.form.fields);
    const fieldKeys = useMemo(() => Object.keys(fields));


    if(props.override) {
        return <>
            {props.override}
        </>
    }
    return <>
        <Form {...props.form.formOptions}>
            {fieldKeys.map((fieldKey, index) => (
                <FormElement key={index} field={fields[fieldKey]} />
            ))}
        </Form>
    </>
}