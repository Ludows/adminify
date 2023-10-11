import React, { useMemo, useEffect,  useState, useContext } from 'react';
import FloatingLabel from 'react-bootstrap/FloatingLabel';
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import useGlide from '../../hooks/useGlide';
import useHelpers from '../../hooks/useHelpers';
import useMediaPicker from '../../hooks/useMediaPicker';
import Paginate from '../../components/MediaPicker/Paginate';
import BtnDeleteMedia from '../../components/MediaPicker/BtnDeleteMedia';
import MediaItem from './MediaItem';
import usePageProps from '../../hooks/usePageProps';

export default function MediaPickerListing(props) {

    const medias = useMemo(() => props.files, [props]);
    const multiple = useMemo(() => props.multiple.current, [props]);
    const folders = useMemo(() => props.dates, [props]);
    const docTypes = useMemo(() => props.types, [props]);
    const deletes = useMemo(() => props.massDelete.current, [props]);
    const [isDeletMode, setDeleteMode] = useState(false);
    const [ deletesIds, setDeletes] = useState([]);
    const { fire } = useHelpers();
    const { get } = usePageProps();
    
    const [image] = useGlide(); //TODO
    
    const {show, hide, addSelection, removeSelection, isInSelection, showActiveMedia, hideActiveMedia, empty, search } = useMediaPicker({
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

    const handleBehaviour = (media, index, isMultiple, DeletMode) => {
        // if() {}
        let routeName = get('currentRouteName');
        console.log(routeName, DeletMode)

        if(routeName == 'admin.medias.index' && !DeletMode) {
            fire('adminify:mediapreview:show', media);
        }
        else {
            handleSelection(media, index, isMultiple, DeletMode);
        }
    }

    const handleSelection = (media, index, isMultiple, DeletMode) => {

            if(DeletMode) {
                setDeletes((ids) => {
                    let inArray = ids.indexOf(media.id) > -1;
                    let filtered = [...ids];
                    if(!inArray) {
                       filtered.push(media.id);
                    }
                    else {
                        filtered = ids.filter((id) => {
                            return id != media.id;
                        })
                    }
                    console.log(filtered);
                    return filtered;
                })
            }
            else {
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
    }

    const onChangeDocTypes = (e) => {
        let o = {
            documents : e.target.value,
        }

        search(o);
    }
    const onChangeFolders = (e) => {
        let o = {
            date : e.target.value,
        }

        search(o);
    }
    const onChangeSearch = (e) => {
        let o = {
            search : e.target.value,
        }

        search(o);
    }

    const handleDeleteMassSelection = (e) => {
        setDeletes([]);
        setDeleteMode(false);
    }

    const toggleDeleteMassSelection = (e) => {
        console.log('click');
        setDeleteMode( !isDeletMode );
    }

    console.log('MediaPickerListing')

    return <>
        <div className='card card-media-opts my-4'>
            <div className='card-body'>
                <div className='row my-3 '>
                    <div className='col-12 d-flex col-lg-7 align-items-center'>
                        <div className={`${isDeletMode ? 'd-none' : ''}`}>
                            <FloatingLabel controlId="floatingSelect" label="@todo types">
                                <Form.Select onChange={onChangeDocTypes}>
                                    {docTypesKeys.map((value, index, array) => {
                                        return <option key={index} value={value}>{docTypes[value]}</option>                        
                                    })}
                                </Form.Select>
                            </FloatingLabel>
                        </div>
                        <div className={`${isDeletMode ? 'd-none' : 'ms-3'}`}>
                            <FloatingLabel controlId="floatingSelect" label="@todo folders">
                                <Form.Select onChange={onChangeFolders}>
                                    {foldersKeys.map((value, index, array) => {
                                        return <option key={index} value={value}>{folders[value]}</option>                        
                                    })}
                                </Form.Select>
                            </FloatingLabel>
                        </div>
                        {deletes == true &&
                            <div className={`${isDeletMode ? '' : 'ms-3'}`}>
                                {isDeletMode == true && 
                                    <BtnDeleteMedia mediaIds={deletesIds} useMassDelete={true} onCompleteDelete={handleDeleteMassSelection} />
                                }
                                <Button onClick={toggleDeleteMassSelection} variant='primary'>Delete</Button>
                            </div>
                        }
                        
                    </div>
                    <div className='col-12 col-lg-5'>
                        <FloatingLabel controlId="floatingSearch" label="@todo search">
                            <Form.Control onChange={onChangeSearch} type="text" />
                        </FloatingLabel>
                    </div>
                </div>
            </div>
        </div>
       
        {medias.data.length > 0 &&
            <div className='row'>
                    {medias.data.map((media, i) => {
                        let isIn = isDeletMode ? deletesIds.indexOf(media.id) > -1 : isInSelection(media);
                        return <MediaItem media={media} key={i} onClick={(e) => { handleBehaviour(media, i, multiple, isDeletMode); }} isActive={isIn} />
                    })}                
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