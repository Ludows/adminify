import React, {useMemo, useRef, useState, useContext, forwardRef, useEffect} from 'react';
import Form from 'react-bootstrap/Form';
import { EmitterContext } from "../../contexts/EmitterContext";
import useErrors from '../../hooks/useErrors';

const BasicChoiceElement = forwardRef((props, ref) => {
  const field = useMemo(() => props.field, []);
  const register = useMemo(() => props.register, [props]);
  const [isInvalid, error] = useErrors(field.name);

  return <>
      <div ref={ref} {...field.wrapper}>
        <Form.Check
          id={field.name}
          type={field.type}
          isInvalid={isInvalid}
        //   defaultValue={field.value ? field.value : ''}
        >
            <Form.Check.Input 
                value={field.value ? field.value : ''}
                type={field.type}
                isInvalid={isInvalid} 
                {...field.attr}
                {...register(field.name)}
            />
            {field.label_show &&
                <Form.Check.Label {...field.label_attr} htmlFor={field.name}>{field.label}</Form.Check.Label>
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
  </>  
}) 

export default BasicChoiceElement;