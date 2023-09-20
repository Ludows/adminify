import React, { useCallback, forwardRef, createRef, useEffect, useMemo } from 'react';
import Dropdown from 'react-bootstrap/Dropdown';
import useTranslations from '../hooks/useTranslations';
import BaseForm from '../components/BaseForm';
import useHelpers from '../hooks/useHelpers';

const ActionItem = forwardRef((props, ref) => {

    const { vars, label, componentName } = props;
    const theUuidForm = useMemo(() => { return vars.form ? vars.form.uuid : null }, [props]);
    const { navigate } = useHelpers();
    const { get } = useTranslations();
    const { onSubmitResults, tableSearch } = useHelpers();
    const theTitle = get(label);

   if(!ref) {
      ref = createRef({});
   }

   const handleForms = (datas) => {
    console.log('from ActionItem', datas.form, vars.form)
    if(theUuidForm == datas.form.uuid) {
        tableSearch({});
    }
   }

   onSubmitResults(handleForms, []);

    useEffect(() => {
    //   console.log('ActionItem.jsx', props, ref);
    }, []);

    const defaultBehaviourClick = (e) => {
        if(!vars.form) {
            doNavigate(vars)
        }
    }

    const doNavigate = (vars) => {
        navigate(vars);
    }

  return vars.form ? <Dropdown.Item onClick={props.onClick ? props.onClick : defaultBehaviourClick} ref={ref} as="li">
                        <BaseForm usePrompt={true} form={vars.form} />
                    </Dropdown.Item> 
                   : <Dropdown.Item ref={ref} onClick={props.onClick ? props.onClick : defaultBehaviourClick}>{ theTitle }</Dropdown.Item>
    

})

export default ActionItem;