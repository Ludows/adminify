import React, {useMemo, forwardRef, useEffect, useState, createRef} from 'react';
import Form from 'react-bootstrap/Form';
import useErrors from '../../hooks/useErrors';
import useHelpers from '../../hooks/useHelpers';

const BasicChoiceElement = forwardRef((props, ref) => {
  if(!ref) {
    ref = createRef({});
  }
  const field = useMemo(() => props.field, [props]);
  const register = useMemo(() => props.register, [props]);
  const [isInvalid, error] = useErrors(field.name);
  const { createCustomRenderer } = useHelpers();
  const [isChecked, setChecked] = useState(field.checked ? field.checked : false);

  useEffect(() => {
    console.log('BasicChoiceElement.jsx', field);
  }, [])

  const handleChecked = () => {
    console.log('click')
    setChecked(!isChecked);
  }

  if(!field) {
    return null;
  }

  let customRender = createCustomRenderer(null, props, ref);

  if(customRender) {
    return customRender;
  }
  
  return <div ref={ref} {...field.wrapper}>
          <Form.Check
            id={field.name}
            type={field.type}
            isInvalid={isInvalid}
          //   defaultValue={field.value ? field.value : ''}
          >
              <Form.Check.Input 
                  defaultValue={field.value}
                  type={field.type}
                  checked={isChecked}
                  isInvalid={isInvalid} 
                  {...field.attr}
                  {...register(field.name)}
              />
              {field.label_show &&
                  <Form.Check.Label onClick={handleChecked} {...field.label_attr} htmlFor={field.name}>{field.label}</Form.Check.Label>
              }
          </Form.Check>
          {field.help_block.text &&
            <Form.Text {...field.help_block.attr} as={field.help_block.tag} muted>
              {field.help_block.text}
            </Form.Text>
          }
          {error &&
              <Form.Control.Feedback type="invalid">
                {error}
              </Form.Control.Feedback>
            }
      </div>
}) 

export default BasicChoiceElement;