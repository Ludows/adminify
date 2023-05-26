import React, { useState, useRef, useEffect, useReducer } from 'react';
import Modal from 'react-bootstrap/Modal';
import Dropzone from "@/back/js/components/Dropzone";
import MediaPickerListing from "@/back/js/components/MediaPicker/MediaPickerListing";
import PreviewZone from "@/back/js/components/MediaPicker/PreviewZone";
import BtnSaveSelection from "@/back/js/components/MediaPicker/BtnSaveSelection";
import useAxios from '@/back/js/hooks/useAxios';
import useMediaPickerSearch from '@/back/js/hooks/useMediaPickerSearch';
import Route from '@/commons/js/Route';
import useMediaPicker from '@/back/js/hooks/useMediaPicker';

export default function MediaPicker(props) {

    const [isVisible, setIsVisible] = useState(false);
    const isMultiple = useRef(false);
    // const [pickerConfig, setPickerConfig] = useState({});

    function reducer (state, config) {
      return {...state, ...config};
    }

    function reducerSelection (state, medias) {
      return [...state, ...medias];
    }

    const [pickerConfig, setPickerConfig] = useReducer(reducer, {});
    const [selectedSelection, setSelectedSelection] = useReducer(reducerSelection, []);

    const [datasFronServer, setDataFromServer] = useState({
      files : {},
      types : {},
      dates : {},
      thumbs : {}
    })
    const [createHttp, http] = useAxios();
    useMediaPickerSearch();
    const { onShow, onResults, onUpdate, config, onHide, addSelection, search } = useMediaPicker();



    const mediaPickerShowListener = (confDatas) => {

      // config(conf)
      // console.log('open modal', pickerConfig);

        let route = Route('medias.listing', {});
        createHttp(route, {
            method: 'post',
        })

        http((errors, datas) => {
            if (errors) {
                console.log('whoops', errors);
                return false;
            }

            if(datas.multiple) {
              isMultiple.current = datas.multiple;
            }
            
            setIsVisible(true);
            setDataFromServer(datas.data);
            // setPickerConfig(config);

            if(confDatas.selection.length > 0) {
              setSelectedSelection(confDatas.selection);
            }

            setPickerConfig(confDatas.config);
            // config(conf);
        })
    }

    onShow(mediaPickerShowListener);

    useEffect(() => {
      // console.log('send config');
      config(pickerConfig);
    }, [pickerConfig])

    useEffect(() => {
      // console.log('send selection');

      selectedSelection.forEach(media => {
        addSelection(media);
      });
      
    }, [selectedSelection])

    const onHideListener = (datas) => {
      setIsVisible(false);
    }

    onHide(onHideListener);

    const onUpdateMetadatasMedia = (datas) => {
      console.log('adminify:mediapicker:update', datas);

      let newDatasFromServer = {...datasFronServer};
      newDatasFromServer.files.data[datas.index] = datas;
      setDataFromServer(newDatasFromServer);
    }

    const handleResults = (datas) => {
      console.log('adminify:mediapicker:results', datas)

      let newDatasFromServer = {...datasFronServer, ...datas.result};
      setDataFromServer(newDatasFromServer);
    }

    onResults(handleResults);

    onUpdate(onUpdateMetadatasMedia, [datasFronServer]);

    const getDropzoneJsConfig = () => {
      return {
        method : 'post',
        url : Route('medias.upload', {}),
        headers : {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        success : function(files) {
          this.removeFile(files);
          // emit('adminify:mediapicker:search', o);
          search({})
        }
      }
    }

    return <>
        <Modal show={isVisible} fullscreen={true} onHide={() => setIsVisible(false)}>
        <Modal.Header closeButton>
          <Modal.Title>Modal</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <div className='row'>
            <div className='col-12 col-lg-7'>
              <Dropzone config={getDropzoneJsConfig()} />
              <MediaPickerListing multiple={isMultiple.current} {...datasFronServer}/>
            </div>
            <PreviewZone/>
          </div>
        </Modal.Body>
        <Modal.Footer>
          <BtnSaveSelection/>
        </Modal.Footer>
      </Modal>
    </>
}
