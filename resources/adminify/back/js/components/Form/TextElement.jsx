import React, {useMemo, forwardRef} from 'react';
import Form from 'react-bootstrap/Form';
import useErrors from '../../hooks/useErrors';
import useHelpers from '../../hooks/useHelpers';

const TextElement = forwardRef((props, ref) => {
  const field = useMemo(() => props.field, []);
  const register = useMemo(() => props.register, [props]);
  const [isInvalid, error] = useErrors(field.name);
  const { createCustomRenderer } = useHelpers();


  if(field.type == 'hidden') {
    field.label_show = false;
  }

  let customRenderer = createCustomRenderer(null, props, ref);

  if(customRenderer) {
    return customRenderer;
  }

  return <div ref={ref} {...field.wrapper}>
          {field.label_show &&
            <Form.Label {...field.label_attr} htmlFor={field.name}>{field.label}</Form.Label>
          }
          <Form.Control
            id={field.name}
            type={field.type}
            isInvalid={isInvalid}
            defaultValue={field.value ? field.value : ''}
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
}) 

export default TextElement;