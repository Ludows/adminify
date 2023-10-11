import React, { createRef, forwardRef } from 'react';
import Breadcrumb from './Breadcrumb';
import usePageProps from './../hooks/usePageProps';
import useHelpers from '../hooks/useHelpers';

const TopPage = forwardRef((props, ref) => {

    if(!ref) {
        ref = createRef({});
    }

    const { get } = usePageProps();
    const { createCustomRenderer } = useHelpers();

    let customRender = createCustomRenderer(null, props, ref);

    if(customRender) {
        return customRender;
    }
    
    const currentRoute = get('currentRouteName'); 
    const items = get('breadcrumb'); 
    const m = get('model');
    const singleParam = get('singleParam');

    return <div ref={ref} className='col-12'>
        <div className='card shadow-sm mb-3'>
            <div className='card-body'>
                <Breadcrumb items={items} currentRoute={currentRoute} model={m} singleParam={singleParam} />
            </div>
        </div>
    </div>

})

export default TopPage;