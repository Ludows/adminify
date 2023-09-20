import React, { useEffect, createRef, forwardRef } from 'react';
import useRoute from '../hooks/useRoute';

import useHelpers from '../hooks/useHelpers';
import useTranslations from '../hooks/useTranslations';

const TopLeftHeader = forwardRef((props, ref) => {
    
    if(!ref) {
        ref = createRef({});
    }

    const { get } = useTranslations();
    let {get:route} = useRoute();
    const { navigate, modal, createCustomRenderer } = useHelpers();

    useEffect(() => {
        console.log('TopLeftHeader.jsx onMounted');
    }, [])

    let customRender = createCustomRenderer(null, props, ref);

    if(customRender) {
        return customRender;
    }

    let dashboardRoute = route('admin.home.dashboard', {});
    
    const handleShowModal = () => {
        modal('globalsearch', {
            show: true,
        })
    }

    const HandleGo = (item) => {
        
        navigate({
            url: item.url,
            method: 'get',
            form: {},
            data: {}
        })

        // setList([]);
        // handleClose();
    }

    return <div ref={ref} className="">
                <button className="h4 mb-0 text-white bg-transparent border-0 text-uppercase d-none d-lg-inline-block" onClick={() => {HandleGo({url : dashboardRoute})}} href="#">{get('admin.root')}</button>
                <a href="#" className="btn btn-default btn-sm rounded" onClick={handleShowModal}>
                    <i className="bi bi-search"></i>
                </a>
            </div>
})

export default TopLeftHeader;