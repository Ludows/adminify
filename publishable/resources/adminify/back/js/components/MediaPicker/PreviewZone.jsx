import React, { useEffect, useState, useRef, useMemo, useContext } from 'react';
import { AdminifyContext } from "../../contexts/AdminifyContext";
import Route from '../../libs/Route';
import useAxios from '../../hooks/useAxios';
import MediaPreviewer from './MediaPreviewer';
import useTranslations from '../../hooks/useTranslations';

export default function PreviewZone(props) {
    const { get:getTranslation } = useTranslations();
    const {on, off, emit} = useContext(AdminifyContext);
    const [activeMedia, setActiveMedia] = useState(props.media ? props.media : null);
    const descriptionRef = useRef(null);
    const altRef = useRef(null);
    const [createHttp, http] = useAxios();

    let { usePreviewer , useFormUpdate} = props;

   if(!props.hasOwnProperty('usePreviewer')) {
     usePreviewer = true;
   }
   
   if(!props.hasOwnProperty('useFormUpdate')) {
    useFormUpdate = true;
   }

    const handleMediaState = (datas) => {

        let condition = datas.active;

        setActiveMedia(condition ? datas : null);
        
    }

    const handleMetadatasMedias = (e) => {
        // Route()
        let route = Route('admin.medias.update', {
            'media': activeMedia.id
        })

        let data = {
            alt : altRef.current.value.trim(),
            description : descriptionRef.current.value.trim(),
            _method : 'put',
        }

        createHttp(route, {
            method : 'post',
            data,
        })

        http((error, datas) => {
            if(error) {
                console.log('whoops', error);
                return false;
            }

            let resultObject = {...activeMedia , ...datas.data.entity}


            setActiveMedia(resultObject);

            emit('adminify:mediapicker:update', resultObject);
            emit('adminify:notify', datas.data);

        })
    }

    const handleDeleteMedia = (e) => {

    }

    useEffect(() => {
        on('adminify:mediapicker:show_media', handleMediaState)
        on('adminify:mediapicker:hide_media', handleMediaState)
        console.log('PreviewZone.jsx mounted', props, usePreviewer)
        return () => {
            off("adminify:mediapicker:show_media", handleMediaState)
            off('adminify:mediapicker:hide_media', handleMediaState)
        }
    }, [])

    return <div className={`col-12 col-lg-5 ${activeMedia ? '' : 'invisible'}`}>
                <div className="row">
                    {(activeMedia && usePreviewer) &&
                        <div className="col-12">
                                <MediaPreviewer media={activeMedia} />
                        </div>
                    }
                    {(activeMedia && useFormUpdate) &&
                    <div class="col-12">
                                <div class="form-group">
                                    <textarea defaultValue={activeMedia.description} className="form-control" onKeyUp={handleMetadatasMedias} ref={descriptionRef} placeholder={getTranslation('admin.media.description')}></textarea>
                                </div>
                                <div class="form-group">
                                    <input defaultValue={activeMedia.alt} type="text" className="form-control" onKeyUp={handleMetadatasMedias} ref={altRef} placeholder={getTranslation('admin.media.alt')}/>
                                </div>

                                {/* <button type="button" onClick={handleDeleteMedia} class="btn btn-danger">{getTranslation('admin.media.delete_image')}</button>
                                <button type="button" class="btn btn-info">{getTranslation('admin.media.edit_media')}</button>                     */}
                    </div>
                    }
                </div>
            </div>
}