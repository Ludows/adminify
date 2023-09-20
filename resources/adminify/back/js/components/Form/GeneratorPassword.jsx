import React, {useMemo, forwardRef, createRef } from 'react';
import Form from 'react-bootstrap/Form';
import useErrors from '../../hooks/useErrors';
import InputGroup from 'react-bootstrap/InputGroup';
import Button from 'react-bootstrap/Button';
import useHelpers from '../../hooks/useHelpers';

const GeneratorPassword = forwardRef((props, ref) => {
  if(!ref) {
    ref = createRef({});
  }

  const field = useMemo(() => props.field, [props]);
  const register = useMemo(() => props.register, [props]);
  const [isInvalid, error] = useErrors(field.name);
  const { createCustomRenderer } = useHelpers();

  let customRenderer = createCustomRenderer(null, props, ref);

  if(customRenderer) {
    return customRenderer;
  }

  return <div ref={ref} {...field.wrapper}>
          {field.label_show &&
            <Form.Label {...field.label_attr} htmlFor={field.name}>{field.label}</Form.Label>
          }
          <InputGroup className="mb-3">
              <Form.Control
                  id={field.name}
                  type="text"
                  isInvalid={isInvalid}
                  aria-describedby="basic-addon1"
                  defaultValue={field.value ? field.value : ''}
                  {...field.attr}
                  {...register(field.name)}
              />
              <Button variant="outline-primary" id="button-addon1">
                  @todo
              </Button>
          </InputGroup>
          
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

export default GeneratorPassword;