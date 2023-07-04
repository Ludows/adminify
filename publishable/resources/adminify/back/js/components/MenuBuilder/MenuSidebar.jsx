import React, { useState, useMemo, forwardRef, createRef } from "react";
import Accordion from 'react-bootstrap/Accordion';
import BaseForm from "../BaseForm";
import useMenu from "../../hooks/useMenu";
import useHelpers from "../../hooks/useHelpers";
const MenuSidebar = forwardRef((props, ref) => {


    let formKeys = useMemo(() => Object.keys(props.forms), [])
    const { loader } = useHelpers();

    const { items } = useMenu();

    if(!ref) {
        ref = createRef({});
    }

    const handleSubmitResults = (datas) => {
        items({
            items: datas.data.items,
            type : datas.data.type,
        });

        loader({
            show: false
        })
    }


    // const 

    return <>
        <Accordion ref={ref} {...props}>
            {formKeys.map((formKey, index, array) => {
               return <Accordion.Item eventKey={index}>
                    <Accordion.Header>{formKey}</Accordion.Header>
                    <Accordion.Body>
                        <BaseForm onSubmitResults={handleSubmitResults} form={props.forms[formKey]} />
                    </Accordion.Body>
                </Accordion.Item>
            })}
        </Accordion>

        <BaseForm form={props.deleteForm} />
    </>
 })

 export default MenuSidebar;