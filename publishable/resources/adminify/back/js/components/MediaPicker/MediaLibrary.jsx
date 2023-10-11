import React, { useMemo, useRef,  useEffect } from 'react';
import PreviewZone from "../../components/MediaPicker/PreviewZone";
import MediaPickerListing from "../../components/MediaPicker/MediaPickerListing";
import Route from '../../libs/Route';
import useMediaPicker from '../../hooks/useMediaPicker';
import Dropzone from "../../components/Dropzone";

export default function MediaLibrary(props) {

    let datasFronServer = useMemo(() => props.datas, [props]);
    let usePreview = useRef(props.usePreview ? props.usePreview : false);
    let useMassDelete = useRef(props.useMassDelete ? props.useMassDelete : false);
    let useMultiple = useRef(props.useMultiple ? props.useMultiple : false);

    const { search } = useMediaPicker();

    console.log('MediaLibrary props', props)

    // useEffect(() => {
    //     console.log('usePreview', usePreview, props.usePreview)
    // }, [])

    const getDropzoneJsConfig = () => {
        return {
          method : 'post',
          url : Route('admin.medias.upload', {}),
          headers : {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          success : function(files) {
            this.removeFile(files);
            search({})
          }
        }
    }

    return <div className='row'>
              <div className={`col-12 ${usePreview.current == true ? 'col-lg-7' : ''}`}>
                <Dropzone config={getDropzoneJsConfig()} />
                <MediaPickerListing massDelete={useMassDelete} multiple={useMultiple} {...datasFronServer}/>
              </div>
              {usePreview.current == true && 
                  <PreviewZone usePreviewer={true} useFormUpdate={true} />
              }
          </div>
}