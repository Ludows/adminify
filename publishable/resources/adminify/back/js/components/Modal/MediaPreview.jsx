import React, { useState, useRef } from 'react';
import Modal from 'react-bootstrap/Modal';
import PreviewZone from '../MediaPicker/PreviewZone';
import useMediaPreview from '@/back/js/hooks/useMediaPreview';
import MediaPreviewer from '../MediaPicker/MediaPreviewer';
import BtnDeleteMedia from  '../MediaPicker/BtnDeleteMedia';
import useMediaPicker from '../../hooks/useMediaPicker';

export default function MediaPreview(props) {
    const [isVisible, setIsVisible] = useState(false);
    const activeMedia = useRef(null);

    const { onShow, onHide } = useMediaPreview({
        useListeners : false
    });

    const { search } = useMediaPicker();

    const triggerPreviewCb = (datas) => {
        activeMedia.current = datas;
        setIsVisible(!isVisible);
    }

    onShow(triggerPreviewCb)
    onHide(() => {
        search({
            
        });
        setIsVisible(false)
    });

    return <>
        <Modal show={isVisible} fullscreen={true} onHide={() => setIsVisible(false)}>
            <Modal.Header closeButton>
            <Modal.Title>Modal</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <div className="row">
                    <div className="col-12 col-lg-7">
                        {activeMedia.current && 
                            <MediaPreviewer media={activeMedia.current}/>
                        }
                    </div>
                    <PreviewZone media={activeMedia.current} usePreviewer={false} useFormUpdate={true} />
                </div>
            </Modal.Body>
            <Modal.Footer>
                {/* <BtnDeleteSelection/> */}
                <BtnDeleteMedia media={activeMedia.current} useMassDelete={false} />
            </Modal.Footer>
      </Modal>
    </>
}