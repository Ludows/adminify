import React, { useEffect, useState, useMemo } from 'react';
import useRoute from '@/commons/js/useRoute';
import { createAxios } from '@/helpers/index';

import { Portal } from 'react-portal';
import Modal from 'react-bootstrap/Modal';
import FloatingLabel from 'react-bootstrap/FloatingLabel';
import Form from 'react-bootstrap/Form';
import ListGroup from 'react-bootstrap/ListGroup';
import useHelpers from '../hooks/useHelpers';
import useTranslations from '../hooks/useTranslations';

export default function TopLeftHeader(props) {

    const { get } = useTranslations();
    let [route] = useRoute('home.dashboard', {});
    let [routeSearchable] = useRoute('searchable', {});
    const { navigate } = useHelpers();

    const [show, setShow] = useState(false);
    const [list, setList] = useState([]);
    
    const listKeys = useMemo(() => {
        return Object.keys(list);
    }, [list]);

    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);

    useEffect(() => {
        console.log('TopLeftHeader.jsx onMounted');
    }, [])

    const handleKeyUp = async(event) => {
        console.log('TopLeftHeader.jsx handleKeyUp()')

        let value = event.target.value;

        if(value.length < 4) {
            setList([]);
            return false;
        }

        let http = createAxios(routeSearchable, {
            method: 'POST',
            data : {
                query : value.trim().toLowerCase()
            }
        })
        
        try {
            let result = await http;
            console.log('TopLeftHeader.jsx handleKeyUp() result', result.data.response)
            setList(result.data.response)
        } catch (error) {
            console.log('TopLeftHeader.jsx handleKeyUp() error', error)
        }
    }

    const HandleGo = (item) => {
        
        navigate({
            url: item.url,
            method: 'get',
            form: {},
            data: {}
        })

        setList([]);
        handleClose();
    }

    return <>
        <div className="">
            <button className="h4 mb-0 text-white bg-transparent border-0 text-uppercase d-none d-lg-inline-block" onClick={() => {HandleGo({url : route})}} href="#">{get('admin.root')}</button>
            <a href="#" className="btn btn-default btn-sm rounded" onClick={handleShow}>
                <i className="bi bi-search"></i>
            </a>
            
            <Portal>
                <Modal show={show} onHide={handleClose}>
                    <Modal.Header closeButton>
                        <Modal.Title>{get('admin.global_search')}</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <FloatingLabel
                            controlId="floatingInput"
                            label={get('admin.search')}
                            className="mb-3"
                        >
                            <Form.Control type="text" onKeyUp={handleKeyUp} placeholder="name@example.com" />
                        </FloatingLabel>

                        <ListGroup>
                            {listKeys.map((listKey, index) => (
                                <>
                                    <p key={index}>{get('admin.menuback.'+listKey)}</p>      
                                    {list[listKey].map((item, indexListItem) => (
                                        <ListGroup.Item key={indexListItem} action onClick={() => {HandleGo(item)}}>
                                           {item.title}
                                        </ListGroup.Item>
                                    ))}
                                </>                             
                            ))}
                            
                        </ListGroup>
                    </Modal.Body>
                </Modal>
            </Portal>
        </div>
    </>
}