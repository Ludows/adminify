import React, {useMemo, useEffect} from 'react';
import Button from 'react-bootstrap/Button';

export default function SubmitElement(props) {
  const field = useMemo(() => props.field, []);

  useEffect(() => {
    console.log('SubmitElement.jsx onMounted', props);
  }, [])

  return <>
      <div {...field.wrapper}>
        <Button {...field.attr} type={field.type}>
          {field.label}
        </Button>
        {/* <Form.Control
          id={field.name}
          type={field.type}
          value={field.value}
          {...field.attr}
        />
        {field.help_block.text &&
          <Form.Text {...field.help_block.attr} as={field.help_block.tag} muted>
            {field.help_block.text}
          </Form.Text>
        } */}
      </div>
  </>  
}