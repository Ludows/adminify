import React, {useMemo, useEffect} from 'react';
import Form from 'react-bootstrap/Form';

export default function TextElement(props) {

  const field = useMemo(() => props.field, []);
  const register = useMemo(() => props.register, [props]);

  if(field.type == 'hidden') {
    field.label_show = false;
  }

  useEffect(() => {
    console.log('TextElement.jsx onMounted', props);
  }, [])

  return <>
      <div {...field.wrapper}>
        {field.label_show &&
          <Form.Label {...field.label_attr} htmlFor={field.name}>{field.label}</Form.Label>
        }
        <Form.Control
          id={field.name}
          type={field.type}
          defaultValue={field.value ? field.value : ''}
          {...field.attr}
          {...register(field.name)}
        />
        {field.help_block.text &&
          <Form.Text {...field.help_block.attr} as={field.help_block.tag} muted>
            {field.help_block.text}
          </Form.Text>
        }
      </div>
  </>  
}