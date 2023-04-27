import React, { useEffect, useMemo } from 'react';
import Form from 'react-bootstrap/Form'

export default function FormElement(props) {

    const field = useMemo(() => props.field);

    useEffect(() => {
        console.log('FormElement.jsx onMounted', field);
    }, [])

    const getRenderer = (field) => {
        switch (field.type) {
            case 'text':
                
                break;
        
            default:
                break;
        }
    }

    return <>
        {getRenderer(field)}
    </>
}