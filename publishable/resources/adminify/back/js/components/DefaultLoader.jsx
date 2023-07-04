import React, { forwardRef, createRef } from 'react';
import { RevolvingDot } from 'react-loader-spinner';
const DefaultLoader = forwardRef((props, ref) => {

   if(!ref) {
      ref = createRef({});
   }


  return <>
    <RevolvingDot
        height="100"
        width="100"
        radius="6"
        color="#4fa94d"
        secondaryColor=''
        ariaLabel="revolving-dot-loading"
        wrapperStyle={{}}
        wrapperClass=""
        visible={true}
        {...props}
    />
  </>
})

export default DefaultLoader;