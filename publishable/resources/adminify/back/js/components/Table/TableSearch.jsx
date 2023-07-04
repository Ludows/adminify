import React, { useEffect, useRef } from 'react';
import FloatingLabel from 'react-bootstrap/FloatingLabel';
import Form from 'react-bootstrap/Form';
import useRoute from '@/commons/js/useRoute';
import useHelpers from '../../hooks/useHelpers';
import usePageProps from '../../hooks/usePageProps';
import useTranslations from '../../hooks/useTranslations';

export default function TableSearch(props) {

    const { get } = useTranslations();
    const { tableSearch, navigate } = useHelpers();
    const { get:appData } = usePageProps();

    let obj_params = {};

    if(appData('siteConfig').multilang == 1){
        obj_params['lang'] = appData('currentLang');
    }
    let [route] = useRoute( appData('name')+ '.create', obj_params)

    useEffect(() => {
        // console.log('TableSearch.jsx onMounted', appData());
    }, [])

    const doSearch = (e) => {
        console.log(e);
        let input = e.target;
        tableSearch({
            search : input.value.trim(),
            page : 1
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

    return <>
        <div class="col d-flex justify-content-end align-items-center text-right">
            <FloatingLabel controlId="floatingPassword" label={get('admin.table.modules.search')}>
                <Form.Control type="text" onKeyUp={doSearch} placeholder={get('admin.table.modules.search')} />
            </FloatingLabel>
            <div class="ml-lg-3 mt-3 mt-lg-0">
                <button onClick={() => { HandleGo({url: route}) }} class="btn btn-sm btn-primary"> {get('admin.table.modules.btn_create')}</button>
            </div>
        </div>
    </>
}