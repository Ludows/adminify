import React, {useMemo, useEffect, useRef} from 'react';
import Form from 'react-bootstrap/Form';

export default function ChoiceElement(props) {

  const field = useMemo(() => props.field, []);
  const choices = useMemo(() => field.choices, [props]);
  const choicesKeys = useMemo(() => Object.keys(choices), [choices]);
  const choiceRef = useRef({});

  useEffect(() => {
    let instanceChoice = new Choices(choiceRef.current, field.select2options ? field.select2options : {});
    
    console.log('ChoiceElement.jsx onMounted', props);

    return () => {
      instanceChoice.destroy();
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
          ref={choiceRef}
          defaultValue={field.value ? field.value : ''}
          {...field.attr}
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