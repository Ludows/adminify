import React, {useMemo, useEffect, forwardRef, createRef} from 'react';
import Button from 'react-bootstrap/Button';
import useHelpers from '../../hooks/useHelpers';

const SubmitElement = forwardRef((props, ref) => {
  const field = useMemo(() => props.field, [props]);
  const { createCustomRenderer } = useHelpers();

  if(!ref) {
    ref = createRef({});
  }

  useEffect(() => {
    // console.log('SubmitElement.jsx onMounted', props);
  }, [])

  let customRenderer = createCustomRenderer(null, props, ref);

  if(customRenderer) {
    return customRenderer;
  }

  return <div ref={ref} {...field.wrapper}>
            <Button {...field.attr} type={field.type}>
              {field.label}
            </Button>
        </div>
});

export default SubmitElement;