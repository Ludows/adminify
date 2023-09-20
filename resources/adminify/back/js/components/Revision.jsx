import React, { useEffect, useMemo, useRef, createRef, forwardRef } from 'react';
import useHelpers from '../hooks/useHelpers';
import ListGroupItem from 'react-bootstrap/ListGroupItem'
import { Button } from 'react-bootstrap';
import usePageProps from '../hooks/usePageProps';
import useTranslations from '../hooks/useTranslations';
import Route from '../libs/Route';

const Revision = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({});
    }
    const { item, idx } = props;
    const { swal, fire, ajax, uuid, onAjaxResult } = useHelpers();
    const { get } = usePageProps();
    const {get:getTranslation} = useTranslations();
    const data = JSON.parse(item.data);
    const theUuid = useMemo(() => uuid(), []);
    const theTitle = getTranslation('revision.title');
    const restoreLabel = getTranslation('revision.restore');
    const showLabel = getTranslation('revision.show');

    const handleShow = () => {
        fire('adminify:revision:show', data);
    }
    const getUrl = () => {

        let single = get('singleParam');
        let routeBase = get('name');

        let o = {};
        o[single] = data.id;

        return  Route( routeBase+'.update' , o);
    }

    const handleRestore = () => {
        swal({
            icon : 'question',
            title: 'Sure to restore ?'
        }, (err, result) => {
            console.log(err, result)
            if(result.isConfirmed) {
                let url = getUrl();
                console.log('url', url);
                ajax({
                    url,
                    method: 'post',
                    data: {
                        ...data,
                        '_method' : 'put',
                        'uuid' : theUuid
                    }
                })
            }
        })
    }

    const bindResultRestore = (datas) => {
        if(datas.uuid === theUuid) {
            window.location.reload();
        }
    }

    onAjaxResult(bindResultRestore, []);
    
    return <ListGroupItem ref={ref} as="li">
        <div className='row align-items-center justify-content-lg-between'>
            <div className="col-12 col-lg-4">
                {theTitle} {idx}
            </div>
            <div className="col-12 col-lg-4">
                <div className='d-flex justify-content-lg-end'>
                    <div><Button variant='primary' onClick={handleShow}>{showLabel}</Button></div>
                    <div className='ms-3'><Button onClick={handleRestore} variant='warning'>{restoreLabel}</Button></div>
                </div>
            </div>
        </div>
    </ListGroupItem>
})  
export default Revision;