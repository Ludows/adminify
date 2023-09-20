import React, { useEffect, useMemo, forwardRef, createRef } from 'react';
import usePageProps from '../../hooks/usePageProps';
import Dropdown from 'react-bootstrap/Dropdown';
import { router } from '@inertiajs/react'
import useHelpers from '../../hooks/useHelpers';

const DropdownLang = forwardRef((props, ref) => {

    if(!ref) {
        ref = createRef({});
    }
    
    const { get } = usePageProps();
    const currentLang = useMemo(() => {
        return get('currentLang');
    }, [])
    
    const langs = useMemo(() => {
        return get('langs');
    }, [])

    const isMultilang = useMemo(() => {
        return get('siteConfig').multilang == 0 ? false : true;
    }, [])

    const changeUrl = (lang) => {
        router.visit(window.location.href, {
            data: {
                lang
            }
        })
    } 

    useEffect(() => {
        console.log('DropdownLang.jsx onMounted', isMultilang);
    }, [])

    const { createCustomRenderer } = useHelpers();    

    if(!isMultilang) {
        return <></>
    }

    let customRender = createCustomRenderer(null, {...props, ...{currentLang, langs, isMultilang} } , ref);

    if(customRender) {
        return customRender;
    }


    return <>
        <Dropdown ref={ref} className='nav-item'>
            <Dropdown.Toggle className='nav-link pr-0 text-white' id="dropdown-basic">
                {currentLang}
            </Dropdown.Toggle>

            <Dropdown.Menu>
                {langs.map((lang) => {
                    if(lang != currentLang) {
                        return <Dropdown.Item as="li" onClick={() => {changeUrl(lang)}}>{lang}</Dropdown.Item>
                    }
                })}
            </Dropdown.Menu>
        </Dropdown>
    </>

});

export default DropdownLang;