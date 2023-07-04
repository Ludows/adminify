import React, { forwardRef, createRef } from 'react';
import Toast from 'react-bootstrap/Toast';
import useTranslations from '../../hooks/useTranslations';
const DefaultBody = forwardRef((props, ref) => {

   if(!ref) {
      ref = createRef({});
   }

   const { get } = useTranslations();


  return <>
    <Toast.Body {...props}>
        {get(props.data.message)}
    </Toast.Body>
  </>
})

export default DefaultBody;