import React, { useEffect, useRef } from 'react';
import FloatingLabel from 'react-bootstrap/FloatingLabel';
import Form from 'react-bootstrap/Form';
import useGlobalStore from '@/back/js/store/global';
import useRoute from '@/commons/js/useRoute';

export default function TableSearch(props) {

    const getTranslation = useGlobalStore(state => state.getTranslation);
    const appData = useGlobalStore(state => state.getAppData);
    const link = useRef('');

    let obj_params = {};

    if(appData('siteConfig').multilang == 1){
        obj_params['lang'] = appData('currentLang');
    }
    let [route] = useRoute( appData('name')+ '.create', obj_params)

    useEffect(() => {
        console.log('TableSearch.jsx onMounted', appData());
    }, [])

    return <>
        <div class="col d-flex justify-content-end align-items-center text-right">
            <FloatingLabel controlId="floatingPassword" label={getTranslation('admin.table.modules.search')}>
                <Form.Control type="text" placeholder={getTranslation('admin.table.modules.search')} />
            </FloatingLabel>
            <div class="ml-lg-3 mt-3 mt-lg-0">
                <a href={route} class="btn btn-sm btn-primary"> {getTranslation('admin.table.modules.btn_create')}</a>
            </div>
        </div>
    </>
}