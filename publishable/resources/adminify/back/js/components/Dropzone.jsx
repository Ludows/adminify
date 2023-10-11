import React, { useCallback, forwardRef, createRef, useEffect, useMemo } from 'react';

const Dropzone = forwardRef((props, ref) => {

   if(!ref) {
      ref = createRef({});
   }

    useEffect(() => {
      console.log('Dropzone.jsx', props, ref)
      let dzInstance = new dz(ref.current, {
        ...props.config
      })

      return () => {
        dzInstance.destroy();
      }
    }, []);


  return <div ref={ref} className='dropzone'></div>
})

export default Dropzone;