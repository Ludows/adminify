import React, { forwardRef, createRef } from 'react';
import BaseForm from '../BaseForm';
import usePageProps from '../../hooks/usePageProps';
// import useRoutes
const AuthRenderer = forwardRef((props, ref) => {

   if(!ref) {
      ref = createRef({});
   }

   const { get } = usePageProps();

   const theForm = get('form');
   

  return <div ref={ref} className='card shadow-sm border-0'>
            <div className='card-body'>
                <BaseForm usePrompt={false} form={ theForm } />
            </div>
            <div className='card-footer'>
                @todo
            </div>
        </div>
})

export default AuthRenderer;