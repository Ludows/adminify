import React, { useEffect, createRef, forwardRef, useRef } from 'react';
import useRoute from '../hooks/useRoute';

import useHelpers from '../hooks/useHelpers';
import useTranslations from '../hooks/useTranslations';
import useRouterEvents from '../hooks/useRouterEvents';
import { Button } from 'react-bootstrap';

import { useLocalStorage } from 'usehooks-ts';

const TopLeftHeader = forwardRef((props, ref) => {
    
    if(!ref) {
        ref = createRef({});
    }

    const { get } = useTranslations();
    let {get:route} = useRoute();
    const { navigate, modal, createCustomRenderer, fire, event } = useHelpers();
    const { onSuccess } = useRouterEvents();
    const btnDashboardRef = useRef({});

    const [expanded, saveExpanded] = useLocalStorage("isExpanded", false);
    const [toggle, saveToggle] = useLocalStorage("isToggled", false);


    useEffect(() => {
        console.log('TopLeftHeader.jsx onMounted');
    }, [])

    onSuccess(({detail}) => {
        
        if(window.location.pathname == '/admin/dashboard') {
            btnDashboardRef.current.setAttribute('disabled', 'disabled');
        }
        else {
            btnDashboardRef.current.removeAttribute('disabled');
        }

        // btnDashboardRef

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
    }

    const handleExpand = (e) => {
        saveExpanded(!expanded)
    }
    
    const handleToggle = (e) => {
        saveToggle(!toggle)
    }

    event('adminify:sidebar', (datas) => {
        if(datas.needClose) {
            saveExpanded(!expanded)
            saveToggle(!toggle)
        }
    })

    useEffect(() => {
        fire('adminify:sidebar', {
            isExpanded: expanded,
            isToggled : toggle,
        })
    }, [expanded, toggle])



    return <div ref={ref} className="d-flex align-items-center">
                <Button variant='outline-dark' active={toggle} className="h4 mb-0 d-inline-block d-lg-none text-uppercase me-3" onClick={handleToggle}>
                    {!toggle ? <i class="bi bi-list"></i> : <i class="bi bi-x-circle"></i>}
                </Button>
                <Button variant='outline-dark' active={expanded} className="h4 mb-0 d-none d-lg-inline-block text-uppercase me-3" onClick={handleExpand}>
                    <i class="bi bi-list"></i>
                </Button>
                
                <button ref={btnDashboardRef} className="h4 mb-0 btn btn-outline-secondary text-uppercase d-none d-lg-inline-block" onClick={() => {HandleGo({url : dashboardRoute})}} href="#"><i class="bi bi-house-door-fill"></i></button>
                <a href="#" className="btn btn-outline-primary btn-sm rounded ms-3" onClick={handleShowModal}>
                    <i className="bi bi-search"></i>
                </a>
            </div>
})

export default TopLeftHeader;