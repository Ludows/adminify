import React, {useMemo, useEffect, forwardRef} from 'react';
import Form from 'react-bootstrap/Form';
import useErrors from '../../hooks/useErrors';

const SelectElement = forwardRef((props, ref) => {
  const field = useMemo(() => props.field, []);
  const choices = useMemo(() => field.choices, [props]);
  const choicesKeys = useMemo(() => Object.keys(choices), [choices]);
  const register = useMemo(() => props.register, [props]);
  const [isInvalid, error] = useErrors(field.name);

  useEffect(() => {
    
    // console.log('SelectElement.jsx onMounted', props);

    return () => {

    }
  }, [])

  return <>
    <div ref={ref} {...field.wrapper}>
        {field.label_show &&
          <Form.Label {...field.label_attr} htmlFor={field.name}>{field.label}</Form.Label>
        }
        <Form.Select
          id={field.name}
          type={field.type}
          isInvalid={isInvalid}
          defaultValue={field.value ? field.value : ''}
          {...field.attr}
          {...register(field.name)}
        >
        
        {choicesKeys.length > 0 && choicesKeys.map((key, i) => <option key={i} value={key}>{choices[key]}</option> )}
            
        </Form.Select>
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
  </>  
});

export default SelectElement;