import React, { useMemo } from 'react';
import { FormProvider } from "react-hook-form";
import Form from 'react-bootstrap/Form';
import useFormComponentRegistrar from '../hooks/useFormComponentRegistrar'
import useHelpers from '../hooks/useHelpers';
// import useGlobalStore from '../store/global';


export default function BaseForm(props) {

    const fields = useMemo(() => props.form.fields, []);
    const formUniqueId = useMemo(() => props.form.uuid, []);
    // const errors = useMemo(() => Object.keys(props.errors).length > 0 ? props.errors.form_errors : {});
    const fieldKeys = useMemo(() => Object.keys(fields));
    // const [on, off, emit] = useContext(EmitterContext);
    const { render, formMethods } = useFormComponentRegistrar(props, props.registerComponents);
    const { submit, onSubmitResults, route, navigate, loader, notify, onErrors, onAppUpdated } = useHelpers();

    const onSubmit = (data, event) => {
        console.log('data from form', data);
        submit({
            ...props,
            data,
        });
    };

    const onDefaultErrorsBehaviour = (datas) => {
        loader({
            show: false
        })
    }

    const defaultSubmitBehaviour = (e) => {
        e.stopPropagation();
        e.preventDefault();

        loader({
            show: true
        })

        return formMethods.handleSubmit(onSubmit)(e);
    }

    const defaultSubmitResultsBehaviour = (datas) => {
        if(formUniqueId == datas.form.uuid) {
            console.log('success', datas);
            let path = route(datas.data.route, {});
        
            notify({
                data : datas.data,
            });
    
            navigate({
                method : 'get',
                url : path,
            })
        }
    }

    onSubmitResults(props.onSubmitResults && typeof props.onSubmitResults == 'function' ? props.onSubmitResults : defaultSubmitResultsBehaviour, []);
    onErrors(props.onErrors && typeof props.onErrors == 'function' ? props.onErrors : onDefaultErrorsBehaviour, [])
    
    onAppUpdated((datas) => {      
        loader({
            show: false
        })
    })

    const renderCustom = () => {
        let CustomComponent = props.render;
        return <CustomComponent fields={fields} renderField={render}/>
    }

    if(props.render) {
        return <>
            <FormProvider {...formMethods}>
                <Form onSubmit={props.onSubmit && typeof props.onSubmit == 'function' ? props.onSubmit : defaultSubmitBehaviour} {...props.form.formOptions}>
                    {renderCustom()}
                </Form>
            </FormProvider>
        </>
    }
    return <>
        <FormProvider {...formMethods}>
            <Form onSubmit={props.onSubmit && typeof props.onSubmit == 'function' ? props.onSubmit : defaultSubmitBehaviour} {...props.form.formOptions}>
                {fieldKeys.map((fieldKey, index) => (
                    render(index, fields[fieldKey])
                ))}
            </Form>
        </FormProvider>
    </>
}