import React, { useState, useRef } from 'react';
import Modal from 'react-bootstrap/Modal';
import useHelpers from '../../hooks/useHelpers';
import usePageProps from '../../hooks/usePageProps';
export default function RevisionViewer(props) {
    const [isVisible, setIsVisible] = useState(false);
    const activeRevision = useRef({});

    const { event } = useHelpers();
    const { get } = usePageProps();

    let config = get('siteConfig');
    const { revisions } = config;

    const handleShow = (datas) => {
        activeRevision.current = datas;
        setIsVisible(true);
    }

    event('adminify:revision:show', handleShow);

    return <Modal show={isVisible} fullscreen={false} onHide={() => setIsVisible(false)}>
            <Modal.Header closeButton>
            <Modal.Title>Modal</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                {Object.keys(activeRevision.current).map((key, index, array) => {
                    if(!revisions.escaped_keys.includes(key)) {
                        return <div key={index} className=''>
                            <div className='fw-bold'>
                                {key}
                            </div>
                            <div className=''>
                                {activeRevision.current[key]}
                            </div>
                        </div>
                    }
                }) }
            </Modal.Body>
      </Modal>
}