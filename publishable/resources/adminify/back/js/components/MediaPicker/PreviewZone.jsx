import React, { useEffect, useState, useRef, useContext } from 'react';
import useGlobalStore from '../../store/global';
import { EmitterContext } from "../../contexts/EmitterContext";
import Route from '@/commons/js/Route';
import useAxios from '@/back/js/hooks/useAxios';

export default function PreviewZone(props) {
    const getTranslation = useGlobalStore(state => state.getTranslation);
    const [on, off, emit] = useContext(EmitterContext);
    const [activeMedia, setActiveMedia] = useState(null);
    const previousMedia = useRef(null);
    const descriptionRef = useRef(null);
    const altRef = useRef(null);
    const [createHttp, http] = useAxios();

    const handleMediaState = (datas) => {

        let condition = datas.active;

        setActiveMedia(condition ? datas : null);
        
    }

    const handleMetadatasMedias = (e) => {
        // Route()
        let route = Route('medias.update', {
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
        return () => {
            off("adminify:mediapicker:show_media", handleMediaState)
            off('adminify:mediapicker:hide_media', handleMediaState)
        }
    }, [])

    return <>
        <div className={`col-12 col-lg-5 ${activeMedia ? '' : 'invisible'}`}>
            <div className="row">
                <div className="col-12">
                    {activeMedia &&
                        
                        <>
                            {activeMedia.mime_type.startsWith('image/') &&
                                <img className="img-fluid mb-3 rounded shadow-lg" alt="" src={activeMedia.path}/>
                            }
                            {activeMedia.mime_type.startsWith('video/') &&
                                <video src={activeMedia.path} className="mb-3"></video>
                            }
                            {activeMedia.mime_type.startsWith('audio/') &&
                                <audio controls src={activeMedia.path} className="mb-3"></audio>
                            }
                            {/* {activeMedia.current.mime_type.startsWith('audio/') &&
                                <iframe src="" className="d-none mb-3 js-preview" id="iframeOriginal"></iframe>
                            } */}
                        </>
                        
                    }
                </div>
                <div class="col-12">
                    {activeMedia &&
                        <>
                            <div class="form-group">
                                <textarea defaultValue={activeMedia.description} className="form-control" onKeyUp={handleMetadatasMedias} ref={descriptionRef} placeholder={getTranslation('admin.media.description')}></textarea>
                            </div>
                            <div class="form-group">
                                <input defaultValue={activeMedia.alt} type="text" className="form-control" onKeyUp={handleMetadatasMedias} ref={altRef} placeholder={getTranslation('admin.media.alt')}/>
                            </div>

                            <button type="button" onClick={handleDeleteMedia} class="btn btn-danger">{getTranslation('admin.media.delete_image')}</button>
                            <button type="button" class="btn btn-info">{getTranslation('admin.media.edit_media')}</button>
                        </>
                    }
                </div>
            </div>
        </div>
    </>
}