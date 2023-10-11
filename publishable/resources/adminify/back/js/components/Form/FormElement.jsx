import React, {useMemo, useState, forwardRef, useEffect} from 'react';
import useErrors from '../../hooks/useErrors';

const FormElement = forwardRef((props, ref) => {
  const field = useMemo(() => props.field, []);
  const register = useMemo(() => props.register, [props]);
  const [isInvalid, error] = useErrors(field.name);


  useEffect(() => {
    console.log('field form', props)
  }, [])

  const renderChildForm = (subfield = {}) => {
    let keyChildFields = Object.keys(subfield.childs);
    let hasFields = keyChildFields.length > 0;

    if(hasFields) {
        return keyChildFields.map((key, k, array) => {
            let child = subfield.childs[key];
            // console.log(props.render(k, child))
            return props.render(k, child);
        })
    }
    return null;
  }

  return <>
       {field.childs.map((subfield, index, array) => 
            renderChildForm(subfield)
        )}
  </>  
}) 

export default FormElement;