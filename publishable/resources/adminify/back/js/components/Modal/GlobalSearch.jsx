import React, { useState, useEffect, useMemo, useRef } from 'react';
import useHelpers from '../../hooks/useHelpers';
import usePageProps from '../../hooks/usePageProps';
import useTranslations from '../../hooks/useTranslations'; 
import useRoute from '../../hooks/useRoute';
import Modal from 'react-bootstrap/Modal';
import FloatingLabel from 'react-bootstrap/FloatingLabel';
import Form from 'react-bootstrap/Form';
import ListGroup from 'react-bootstrap/ListGroup';
import { useDebounce } from 'usehooks-ts';

export default function GlobalSearch(props) {
    const { event, uuid, ajax, onAjaxResult, navigate, modal } = useHelpers();
    const { get } = usePageProps();
    const [value, setValue] = useState();
    const isOnSearch = useRef(false);
    const theUuid = useMemo(() => uuid(), []);
    const { get:route } = useRoute();
    const { getTranslations, get:translate } = useTranslations();
    const debouncedValue = useDebounce(value , 500);
    const config = get('siteConfig');


    const translations = getTranslations([
        'admin.global_search',
        'admin.search',
    ]);
    
    let routeSearchable = route('admin.searchable', {});

    const [show, setShow] = useState(false);
    const [list, setList] = useState([]);

    const handleModal = (datas) => {
        if(datas.show) {
            setShow(datas.show);
        }
    }

    event('adminify:modal:globalsearch', handleModal, []);

    const listKeys = useMemo(() => {
        return Object.keys(list);
    }, [list]);

    const labels = useRef({});

    let keyedTranslations = useMemo(() => {
        let o = {};
        listKeys.forEach((listKey) => {
            o['admin.menuback.'+listKey] = translate('admin.menuback.'+listKey)
        });
        return o;
    }, [listKeys]) 

    useEffect(() => {
        if(debouncedValue) {
            let o = {};
            o[config.searchable.admin.name] = debouncedValue;
            o['uuid'] = theUuid;

            ajax({
                method: 'POST',
                url : routeSearchable,
                data: o,
            })
        }
        else {
            isOnSearch.current = false;
            setList([]);
        }
        
    }, [debouncedValue])


    const handleAjax = (datas) => {
        if(datas.uuid === theUuid) {
            isOnSearch.current = true;

            // labels.current = datas.labels;
            setList(datas.response);
        }
    }

    onAjaxResult(handleAjax, []);

    const handleClose = () => {
        isOnSearch.current = false;
        setList([]);
        setShow(false);
    };

    const HandleGo = (item) => {

        console.log(item)

        setList([]);
        setShow(false);

        navigate({
            url: item.url,
            method: 'get',
            form: {},
            data: {}
        })
        
    }

    const handleKeyUp = async(event) => {
        console.log('GlobalSearch.jsx handleKeyUp()')

        let value = event.target.value;
        setValue(value.trim());
    }


    return <Modal show={show} onHide={handleClose}>
                <Modal.Header closeButton>
                    <Modal.Title>{translations['admin.global_search']}</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <FloatingLabel
                        controlId="floatingInput"
                        label={translations['admin.search']}
                        className="mb-3"
                    >
                        <Form.Control type="text" onKeyUp={handleKeyUp} placeholder="name@example.com" />
                    </FloatingLabel>

                    {(listKeys.length == 0 && isOnSearch.current == true) && 
                        <p className='test'> no results </p>
                    }

                    {listKeys.length > 0 && 
                        <ListGroup>

                            {listKeys.map((listKey, index) => (
                                <>
                                    <p className='bg-info rounded-3 text-white px-3 py-2 mb-0 mt-3' key={index}>{keyedTranslations['admin.menuback.'+listKey]}</p>      
                                    {list[listKey].map((item, indexListItem) => (
                                        <ListGroup.Item key={indexListItem} action onClick={() => {HandleGo(item)}}>
                                        {item.title}
                                        </ListGroup.Item>
                                    ))}
                                </>                             
                            ))}
                        
                        </ListGroup>
                    }

                    
                </Modal.Body>
            </Modal>
}