import React, { useMemo, useState, useEffect, createRef, useContext } from 'react';
import { useForm, FormProvider } from "react-hook-form";
import Form from 'react-bootstrap/Form';

import TextElement from '@/back/js/components/Form/TextElement';
import MediaElement from '@/back/js/components/Form/MediaElement';
import SubmitElement from '@/back/js/components/Form/SubmitElement';
import ChoiceElement from '@/back/js/components/Form/ChoiceElement';
import SelectElement from '@/back/js/components/Form/SelectElement';
import VisualEditorElement from '@/back/js/components/Form/VisualEditorElement';

import { EmitterContext } from "../contexts/EmitterContext";
import useGlobalStore from '../store/global';


export default function BaseForm(props) {

    const fields = useMemo(() => props.form.fields);
    // const errors = useMemo(() => Object.keys(props.errors).length > 0 ? props.errors.form_errors : {});
    const fieldKeys = useMemo(() => Object.keys(fields));
    const methods = useForm();
    const [on, off, emit] = useContext(EmitterContext);

    const onSubmit = (data, event) => {
        
        emit('adminify:submit', {
            ...props,
            data,
        });
    };
    
    const Fields = useMemo(() => {
        let registered_components = {};
        let listed_components = {};

        let coreFields = {
            'text' : TextElement,
            'hidden' : TextElement,
            'media_element' : MediaElement,
            'visual_editor' : VisualEditorElement,
            'submit' : SubmitElement,
            'select2' : ChoiceElement,
            'select' : SelectElement,
        }

        if(props.registerComponents && typeof props.registerComponents === "function") {
            let results_register_components = props.registerComponents(props);
            if(results_register_components && typeof results_register_components === "object") {
                registered_components = results_register_components;
            }
        }

        listed_components = Object.assign({}, coreFields, registered_components);

        console.log('Avalaibles components', listed_components);


        return listed_components;
    }, [fields])

    const fieldAdapter = () => {
        console.log("todo");
    }

    const getRenderer = (key, field) => {

        let Component = Fields[field.type];

        let componentRef = createRef({});
        
        if(Component) {
            return <Component ref={componentRef} register={methods.register} key={key} field={field} />
        }
        else {
            console.warn('Form FieldType '+ field.type + ' is not recognized. Have you registered this one ?');
        }
    }


    if(props.override) {
        return <>
            {props.override}
        </>
    }
    return <>
        <FormProvider {...methods}>
            <Form onSubmit={e =>{
                e.stopPropagation();
                e.preventDefault();

                return methods.handleSubmit(onSubmit)(e);
            }} {...props.form.formOptions}>
                {fieldKeys.map((fieldKey, index) => (
                    getRenderer(index, fields[fieldKey])
                ))}
            </Form>
        </FormProvider>
    </>
}