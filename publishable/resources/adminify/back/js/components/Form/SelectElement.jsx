import React, {useMemo, useEffect} from 'react';
import Form from 'react-bootstrap/Form';

export default function SelectElement(props) {

  const field = useMemo(() => props.field, []);
  const choices = useMemo(() => field.choices, [props]);
  const choicesKeys = useMemo(() => Object.keys(choices), [choices]);
  const register = useMemo(() => props.register, [props]);

  useEffect(() => {
    
    console.log('SelectElement.jsx onMounted', props);

    return () => {

    }
  }, [])

  return <>
    <div {...field.wrapper}>
        {field.label_show &&
          <Form.Label {...field.label_attr} htmlFor={field.name}>{field.label}</Form.Label>
        }
        <Form.Select
          id={field.name}
          type={field.type}
          defaultValue={field.value ? field.value : ''}
          {...field.attr}
          {...register(field.name)}
        >
        
        {choicesKeys.length > 0 && choicesKeys.map((key) => <option value={key}>{choices[key]}</option> )}
            
        </Form.Select>
        {field.help_block.text &&
          <Form.Text {...field.help_block.attr} as={field.help_block.tag} muted>
            {field.help_block.text}
          </Form.Text>
        }
    </div>
  </>  
}