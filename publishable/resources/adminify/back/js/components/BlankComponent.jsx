import { createRef, forwardRef } from 'react';
import useHelpers from '../hooks/useHelpers';

const BlankComponent = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({});
    }

    const { createCustomRenderer } = useHelpers();

    let customRender = createCustomRenderer(null, props, ref);

    if(customRender) {
        return customRender;
    }

    return null;

})

export default BlankComponent;