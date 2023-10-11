
import React, {useEffect, useMemo, createRef} from 'react';

import TextElement from '../components/Form/TextElement';
import TextareaElement from '../components/Form/TextareaElement';
import MediaElement from '../components/Form/MediaElement';
import SubmitElement from '../components/Form/SubmitElement';
import ChoiceElement from '../components/Form/ChoiceElement';
import SelectElement from '../components/Form/SelectElement';
import VisualEditorElement from '../components/Form/VisualEditorElement';
import BasicChoiceElement from '../components/Form/BasicChoiceElement';
import GeneratorPassword from '../components/Form/GeneratorPassword';
import FlatpickrElement from '../components/Form/FlatpickrElement';
import JoditElement from '../components/Form/JoditElement';
import FormElement from '../components/Form/FormElement';
import { useForm } from "react-hook-form";

export default function useFormComponentRegistrar(props = {}, registerCb = null) {

    const formMethods = useForm({
        resetOptions: {
            keepDirtyValues: true, // user-interacted input will be retained
            keepErrors: true, // input errors will be retained with value update
        }
    });


    const Fields = useMemo(() => {
        let registered_components = {};
        let listed_components = {};

        let coreFields = {
            'text' : TextElement,
            'hidden' : TextElement,
            'tel' : TextElement,
            'email' : TextElement,
            'password' : TextElement,
            'color' : TextElement,
            'media_element' : MediaElement,
            'visual_editor' : VisualEditorElement,
            'generatorPassword' : GeneratorPassword,
            'flatpickr' : FlatpickrElement,
            'submit' : SubmitElement,
            'select2' : ChoiceElement,
            'select' : SelectElement,
            'checkbox' : BasicChoiceElement,
            'radio' : BasicChoiceElement,
            'jodit' : JoditElement,
            'form' : FormElement,
            'textarea' : TextareaElement
        }

        if(registerCb && typeof registerCb === "function") {
            let results_register_components = registerCb(props);
            if(results_register_components && typeof results_register_components === "object") {
                registered_components = results_register_components;
            }
        }

        listed_components = Object.assign({}, coreFields, registered_components);

        // console.log('Avalaibles components', listed_components);

        return listed_components;
    }, [])

    const getRenderer = (key, field) => {

        let Component = Fields[field.type];

        let componentRef = createRef({});
        
        if(Component) {
            return <Component ref={componentRef} render={ field.type == 'form' ? getRenderer : null } register={formMethods.register} key={key} field={field} />
        }
        else {
            console.warn('Form FieldType '+ field.type + ' is not recognized. Have you registered this one ?');
        }
    }

    const fieldAdapter = () => {
        console.log("todo");
    }

    let methods = {
        render : getRenderer,
        formMethods : formMethods
    }
    
    return methods;
}
