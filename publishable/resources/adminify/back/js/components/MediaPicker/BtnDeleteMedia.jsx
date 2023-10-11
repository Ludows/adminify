import React, { forwardRef, createRef, useMemo } from 'react';
import Button from 'react-bootstrap/Button';
import useHelpers from '../../hooks/useHelpers';
import Route from '../../libs/Route';
import { createAxios } from '../../../../helpers/index.js';
import useMediaPicker from '../../hooks/useMediaPicker';

const BtnDeleteMedia = forwardRef((props, ref) => {

   const { ajax , onAjaxResult, uuid, fire, swal, notify } = useHelpers();
//    const { hide } = useMediaPreview();
   const deleteUuid = useMemo(() => uuid(), [props]);
   const media = useMemo(() => props.media, [props]);
   const media_ids = useMemo(() => !props.hasOwnProperty('mediaIds') ? [] : props.mediaIds, [props]);
   const useMassDelete = useMemo(() => !props.hasOwnProperty('useMassDelete') ? false : props.useMassDelete, [props]);

   const { search } = useMediaPicker({
    useListeners : false
   });


   const handleDisabledState = () => {
        let ret = false;
        if(useMassDelete) {
            ret = media_ids.length == 0;
        }
        else {
            ret = !media.hasOwnProperty('id');
        }

        return ret;
   }

   const handleResult = (datas) => {
        if(deleteUuid == datas.uuid) {
            fire('adminify:mediapreview:hide', media);
            notify({});
        }
   }

   onAjaxResult(handleResult, []);

   if(!ref) {
      ref = createRef({});
   }

   if(!props.media && useMassDelete == false) {
     return <></>;
   }

   const createUrls = () => {
    let array_of_deletes_url = [];
    media_ids.forEach((id, index, array) => {

        let theUrl = getUrlFormDelete(id);

        array_of_deletes_url.push(
            createAxios(theUrl, {
                method : 'POST',
                data : {
                    'uuid' : deleteUuid,
                    '_method' : 'delete'
                }
            })
        )
    });

    return array_of_deletes_url;
   }

   const getUrlFormDelete = (media) => {
     return Route('admin.medias.destroy', { media : media.id ? media.id : media });
   }

    const handleCLick = (e) => {
        let the_url = null;

        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }, (error, result) => {
            console.log(error, result);

            if(useMassDelete) {
                if(result.isConfirmed) {
                    let urls = createUrls();
                    Promise.all(urls).then((values) => {
                        search();
    
                        if(props.onCompleteDelete && typeof props.onCompleteDelete === "function") {
                            props.onCompleteDelete(media_ids);
                        }
                        notify({});
                    })
                }
            }
            else {
                if(result.isConfirmed) {
                    the_url = getUrlFormDelete(media);
    
                    ajax({
                        url : the_url,
                        method : 'POST',
                        data : {
                            'uuid' : deleteUuid,
                            '_method' : 'delete'
                        }
                    })
                }
            }

            
            
        })

        
    } 

    return <Button className='me-2' ref={ref} disabled={handleDisabledState()} onClick={handleCLick} variant="danger">{ useMassDelete ? 'handle mass delete' : 'delete' }</Button>
})

export default BtnDeleteMedia;