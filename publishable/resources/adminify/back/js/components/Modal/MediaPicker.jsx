import React, { useState, useRef, useEffect, useReducer } from 'react';
import Modal from 'react-bootstrap/Modal';
import BtnSaveSelection from "../../components/MediaPicker/BtnSaveSelection";
import useAxios from '../../hooks/useAxios';
import useMediaPickerSearch from '../../hooks/useMediaPickerSearch';
import Route from '../../libs/Route';
import useMediaPicker from '../../hooks/useMediaPicker';
import MediaLibrary from '../MediaPicker/MediaLibrary';

export default function MediaPicker(props) {

    const [isVisible, setIsVisible] = useState(false);
    const isMultiple = useRef(false);
    const preventRequest = useRef(false);
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

        let route = Route('admin.medias.listing', {});
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
      preventRequest.current = !isVisible;
    }, [isVisible])

    useEffect(() => {
      selectedSelection.forEach(media => {
        addSelection(media);
      });
      
    }, [selectedSelection])

    const onHideListener = (datas) => {
      setIsVisible(false);
    }

    const getVisible = () => {
      return isVisible;
    }

    onHide(onHideListener);

    const onUpdateMetadatasMedia = (datas) => {
      if(preventRequest.current) {
        return false;
      }
      console.log('adminify:mediapicker:update', datas);

      let newDatasFromServer = {...datasFronServer};
      newDatasFromServer.files.data[datas.index] = datas;
      setDataFromServer(newDatasFromServer);
    }

    const handleResults = (datas) => {
      console.log('isVisible', preventRequest.current)
      if(preventRequest.current) {
        return false;
      }
      console.log('adminify:mediapicker:results', datas)

      let newDatasFromServer = {...datasFronServer, ...datas.result};
      setDataFromServer(newDatasFromServer);
    }

    onResults(handleResults);

    onUpdate(onUpdateMetadatasMedia, [datasFronServer]);

    return <Modal show={isVisible} fullscreen={true} onHide={() => setIsVisible(false)}>
        <Modal.Header closeButton>
          <Modal.Title>Modal</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <MediaLibrary usePreview={true} useMassDelete={false} multiple={isMultiple.current} datas={{...datasFronServer}}  />
        </Modal.Body>
        <Modal.Footer>
          <BtnSaveSelection/>
        </Modal.Footer>
      </Modal>
}
