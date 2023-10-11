import React, {useMemo, forwardRef, createRef} from 'react';
import Form from 'react-bootstrap/Form';
import useErrors from '../../hooks/useErrors';
import useHelpers from '../../hooks/useHelpers';

const SelectElement = forwardRef((props, ref) => {
  
  if(!ref) {
    ref = createRef({});
  }

  const field = useMemo(() => props.field, [props]);
  const choices = useMemo(() => field.choices, [props]);
  const choicesKeys = useMemo(() => Object.keys(choices), [choices]);
  const register = useMemo(() => props.register, [props]);
  const [isInvalid, error] = useErrors(field.name);
  const { createCustomRenderer, formatValue } = useHelpers();

  let customRenderer = createCustomRenderer(null, props, ref);
  let valueFormater = formatValue(field.value);

  if(customRenderer) {
    return customRenderer;
  }

  return <>
    <div ref={ref} {...field.wrapper}>
        {field.label_show &&
          <Form.Label {...field.label_attr} htmlFor={field.name}>{field.label}</Form.Label>
        }
        <Form.Select
          id={field.name}
          type={field.type}
          isInvalid={isInvalid}
          defaultValue={valueFormater}
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