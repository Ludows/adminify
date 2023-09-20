import React, { forwardRef, createRef } from 'react';
import Toast from 'react-bootstrap/Toast';

const DefaultHeader = forwardRef((props, ref) => {

   if(!ref) {
      ref = createRef({});
   }


  return <Toast.Header {...props}>
            {/* {props.content} */}
        </Toast.Header>
})

export default DefaultHeader;