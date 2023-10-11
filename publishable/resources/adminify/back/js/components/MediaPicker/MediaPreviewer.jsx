import React, { forwardRef, createRef, useMemo } from 'react';

const MediaPreviewer = forwardRef((props, ref) => {

    const media = useMemo(() => props.media, [])
   if(!ref) {
      ref = createRef({});
   }

   if(!props.media) {
     return null;
   }


  return <>
        {media.mime_type.startsWith('image/') &&
            <img className="img-fluid mb-3 rounded shadow-lg" alt="" src={media.path}/>
        }
        {media.mime_type.startsWith('video/') &&
            <video src={media.path} className="mb-3"></video>
        }
        {media.mime_type.startsWith('audio/') &&
            <audio controls src={media.path} className="mb-3"></audio>
        }
        {/* {activeMedia.current.mime_type.startsWith('audio/') &&
            <iframe src="" className="d-none mb-3 js-preview" id="iframeOriginal"></iframe>
        } */}
    </>
})

export default MediaPreviewer;