import React, { useMemo, useEffect, useState, useContext } from 'react';
import FloatingLabel from 'react-bootstrap/FloatingLabel';
import Form from 'react-bootstrap/Form';
import useGlide from '@/back/js/hooks/useGlide';
import useMediaPicker from '@/back/js/hooks/useMediaPicker';
import Paginate from '@/back/js/components/MediaPicker/Paginate';
import { EmitterContext } from "../../contexts/EmitterContext";

export default function MediaPickerListing(props) {

    const medias = useMemo(() => props.files, [props]);
    const multiple = useMemo(() => props.multiple, [props]);
    const folders = useMemo(() => props.dates, [props]);
    const docTypes = useMemo(() => props.types, [props]);
    
    const [image] = useGlide(); //TODO
    const [on, off, emit] = useContext(EmitterContext);
    const {show, hide, addSelection, removeSelection, isInSelection, showActiveMedia, hideActiveMedia, empty} = useMediaPicker({
        useListeners : true
    });


    const docTypesKeys = useMemo(() => {
        return Object.keys(docTypes);
    }, [])

    const foldersKeys = useMemo(() => {
        return Object.keys(folders);
    }, [])

    const sendSelection = (datas) => {
        addSelection(datas);
    }

    const handleSelection = (media, index, isMultiple) => {
        let isIn = isInSelection(media);
        if(!isIn) {
            if(!isMultiple) {
                empty();
            }
            sendSelection(media);
            showActiveMedia({...media, active : true, index});
        }
        else {
            removeSelection(media);
            hideActiveMedia({...media, active : false, index});
        }
    }

    const onChangeDocTypes = (e) => {
        let o = {
            documents : e.target.value,
        }

        emit('adminify:mediapicker:search', o);
    }
    const onChangeFolders = (e) => {
        let o = {
            date : e.target.value,
        }

        emit('adminify:mediapicker:search', o);
    }
    const onChangeSearch = (e) => {
        let o = {
            search : e.target.value,
        }

        emit('adminify:mediapicker:search', o);
    }

    


    return <>
        <div className='row my-3'>
            <div className='col-12 d-flex col-lg-7'>
                <div className=''>
                    <FloatingLabel controlId="floatingSelect" label="@todo types">
                        <Form.Select onChange={onChangeDocTypes}>
                            {docTypesKeys.map((value, index, array) => {
                                return <option key={index} value={value}>{docTypes[value]}</option>                        
                            })}
                        </Form.Select>
                    </FloatingLabel>
                </div>
                <div className='ms-3'>
                    <FloatingLabel controlId="floatingSelect" label="@todo folders">
                        <Form.Select onChange={onChangeFolders}>
                            {foldersKeys.map((value, index, array) => {
                                return <option key={index} value={value}>{folders[value]}</option>                        
                            })}
                        </Form.Select>
                    </FloatingLabel>
                </div>
            </div>
            <div className='col-12 col-lg-5'>
                <FloatingLabel controlId="floatingSearch" label="@todo search">
                    <Form.Control onChange={onChangeSearch} type="text" />
                </FloatingLabel>
            </div>
        </div>
        {medias.data.length > 0 &&
            <div className='row'>
                <>
                    {medias.data.map((media, i) => {
                        let isIn = isInSelection(media);
                        let active = isIn ? 'active' : '';
                        return <a key={i} href='#' onClick={(e) => { handleSelection(media, i, multiple); }} className={`col-12 mb-3 shadow-sm col-lg-3 position-relative ${active}`}>
                            <img className='img-fluid' src={media.path} />
                        </a>
                    })}
                </>
                
            </div>
        }
        {medias.data.length == 0 &&
            <p>No medias found</p>
        }

        {medias.data.length > 0 &&
            <Paginate links={medias.links}/>
        }
    </>
}