import React, { forwardRef, createRef, useMemo } from 'react';

const MediaItem = forwardRef((props, ref) => {

    const media = useMemo(() => props.media ?? {}, [props]);
    const active = () => {
        return props.isActive ? 'active' : '';
    } 
    
    const clickFn = useMemo(() => props.onClick ? props.onClick : () => {}, [props]);
   if(!ref) {
      ref = createRef({});
   }

  return <a ref={ref} href='#' onClick={clickFn} className='col-12 mb-3 col-lg-3 position-relative'>
            <div className={`card mediaItem shadow-sm ${active()}`}>
                <div className='card-body'>
                    <img className='img-fluid' src={media.path} />
                    {media.src}
                </div>
            </div>
            
        </a>
})

export default MediaItem;