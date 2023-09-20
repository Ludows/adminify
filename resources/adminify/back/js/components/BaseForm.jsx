import React, { useMemo, forwardRef, createRef } from 'react';
import { FormProvider } from "react-hook-form";
import Form from 'react-bootstrap/Form';
import useFormComponentRegistrar from '../hooks/useFormComponentRegistrar'
import useHelpers from '../hooks/useHelpers';
import useTranslations from '../hooks/useTranslations';
// import useGlobalStore from '../store/global';

const BaseForm = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({});
    }
    const { get } = useTranslations();
    const fields = useMemo(() => props.form.fields, []);
    const formUniqueId = useMemo(() => props.form.uuid, []);
    // const errors = useMemo(() => Object.keys(props.errors).length > 0 ? props.errors.form_errors : {});
    const fieldKeys = useMemo(() => Object.keys(fields));
    const usePrompt = useMemo(() => { return props.usePrompt ? props.usePrompt : false }, [props]);
    
    const promptConfig = useMemo(() => {
        let def = {
            icon : 'question',
            title : get('admin.prompt_question'),
            
        }

        let promptOveride = props.promptConfig ? props.promptConfig : {}

        return {...def, ...promptOveride }
    }, [props]);
    // const [on, off, emit] = useContext(EmitterContext);
    const { render, formMethods } = useFormComponentRegistrar(props, props.registerComponents);
    const { submit, onSubmitResults, route, navigate, loader, notify, onErrors, onAppUpdated, swal, createCustomRenderer } = useHelpers();

    const defaultPromptCb = (err, result, data) => {
        if(result.isConfirmed) {
            submit({
                ...props,
                data,
            });
        }
    }
    const promptCb = useMemo(() => { return props.onPrompt ? props.onPrompt : defaultPromptCb }, [props]);

    const onSubmit = (data, event) => {
        console.log('data from form', data);
        if(usePrompt) {
            swal(promptConfig, promptCb, data);
        }
        else {
            submit({
                ...props,
                data,
            });
        }
        
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

            let hasUrlKey = datas.data.hasOwnProperty('url');
            let path = '/';
            if( hasUrlKey ) {
                path = datas.data.url;
            }
            else {
                path = route( datas.data.route, {});
            }

        
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

    const renderCustom = (props, ref) => {
        let CustomComponent = props.render;
        return <CustomComponent ref={ref} fields={fields} renderField={render} {...props} />
    }

    let customRenderer = createCustomRenderer(renderCustom, props, ref)

    if(customRenderer) {
        // customRenderer = renderCustom();
        return <FormProvider {...formMethods}>
                    <Form onSubmit={props.onSubmit && typeof props.onSubmit == 'function' ? props.onSubmit : defaultSubmitBehaviour} {...props.form.formOptions}>
                        {customRenderer}
                    </Form>
                </FormProvider>
        
    }
    return <FormProvider {...formMethods}>
                <Form onSubmit={props.onSubmit && typeof props.onSubmit == 'function' ? props.onSubmit : defaultSubmitBehaviour} {...props.form.formOptions}>
                    {fieldKeys.map((fieldKey, index) => (
                        render(index, fields[fieldKey])
                    ))}
                </Form>
            </FormProvider>
})

export default BaseForm;