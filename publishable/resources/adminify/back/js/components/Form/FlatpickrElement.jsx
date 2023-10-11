import React, {useMemo, forwardRef, useEffect, createRef} from 'react';
import Form from 'react-bootstrap/Form';
import useErrors from '../../hooks/useErrors';
import flatpickr from 'flatpickr';
import useHelpers from '../../hooks/useHelpers';

const FlatpickrElement = forwardRef((props, ref) => {
  if(!ref) {
    ref = createRef({});
  }
  const field = useMemo(() => props.field, []);
  const register = useMemo(() => props.register, [props]);
  const [isInvalid, error] = useErrors(field.name);
  const { createCustomRenderer } = useHelpers();

  useEffect(() => {
      if(ref.current) {
        let el = ref.current.querySelector("input");
        let instance = null;
        if(el) {
          instance = flatpickr(el, field.flatpickr_options);
        }
        return () => {
          if(instance) {
            instance.destroy();
          }
        }
      }
  }, [])

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
          type="text"
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

export default FlatpickrElement;