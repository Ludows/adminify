import React, {useMemo, forwardRef,useState, useEffect, useRef } from 'react';
import Form from 'react-bootstrap/Form';
import useErrors from '../../hooks/useErrors';
import { Jodit } from 'jodit';
import 'jodit/build/jodit.min.css';
import { useFormContext } from "react-hook-form";

const JoditElement = forwardRef((props, ref) => {


  const field = useMemo(() => props.field, []);
  const register = useMemo(() => props.register, [props]);
  const [isInvalid, error] = useErrors(field.name);
  const [content, setContent] = useState(field.value ? field.value : '');
  const { setValue } = useFormContext();

  const config = useMemo(
    () => { props.jodit_options },
    [props]
  );

  

  useEffect(() => {
    let textarea = ref.current.querySelector('input[type="text"]');
    let instance = null;

    const blurEvent = function(e) {
        setValue(field.name, instance.value);
        setContent(instance.value);
    }

    if(textarea) {
        instance = Jodit.make(textarea, config);
        instance.events.on('change', blurEvent)
    }
    return () => {
        if(instance) {
            instance.events.off('change', blurEvent)
            instance.destruct(); 
        }
    }
  }, [])

  return <>
      <div ref={ref} {...field.sibling_attr} id={field.sibling}>
        <div {...field.wrapper}>
            {field.label_show &&
                <Form.Label {...field.label_attr} htmlFor={field.name}>{field.label}</Form.Label>
            }
            <Form.Control
                id={field.name}
                type="text"
                isInvalid={isInvalid}
                defaultValue={content}
                {...field.attr}
                {...register(field.name)}
            />
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
      </div>
  </>  
}) 

export default JoditElement;