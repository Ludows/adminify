import React, { useEffect, useState, useRef } from 'react';
import useGlobalStore from '../store/global';
import useRoute from '@/commons/js/useRoute';
import { Portal } from 'react-portal';

import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';
import FloatingLabel from 'react-bootstrap/FloatingLabel';
import Form from 'react-bootstrap/Form';

import { createAxios } from '@/helpers/index';
 
export default function TopLeftHeader(props) {

    const getTranslation = useGlobalStore(state => state.getTranslation);
    let [route] = useRoute('home.dashboard', {});
    let [routeSearchable] = useRoute('searchable', {});
    let { previousRequest, current } = useRef(null);

    const [show, setShow] = useState(false);
    const [list, setList] = useState({});

    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);

    useEffect(() => {
        console.log('TopLeftHeader.jsx onMounted');
    }, [])

    const handleKeyUp = async(event) => {
        console.log('TopLeftHeader.jsx handleKeyUp()', event)
        let http = createAxios(routeSearchable, {
            method: 'POST',
        })
        
        try {
            let result = await http;
            console.log('TopLeftHeader.jsx handleKeyUp() result', result)
        } catch (error) {
            console.log('TopLeftHeader.jsx handleKeyUp() error', error)
        }
    }

    // {{ route('home.dashboard') }}
    // {{ __('admin.root') }}
    return <>
        <div className="">
            <a className="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href={route}>{getTranslation('admin.root')}</a>
            <a href="#" className="btn btn-default btn-sm rounded" onClick={handleShow}>
                <i className="bi bi-search"></i>
            </a>
            
            <Portal>
                <Modal show={show} onHide={handleClose}>
                    <Modal.Header closeButton>
                        <Modal.Title>{getTranslation('admin.global_search')}</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <FloatingLabel
                            controlId="floatingInput"
                            label={getTranslation('admin.search')}
                            className="mb-3"
                        >
                            <Form.Control type="text" onKeyUp={handleKeyUp} placeholder="name@example.com" />
                        </FloatingLabel>
                    </Modal.Body>
                </Modal>
            </Portal>
        </div>
    </>
}