import React, { useEffect, useRef, useContext } from 'react';
import FloatingLabel from 'react-bootstrap/FloatingLabel';
import Form from 'react-bootstrap/Form';
import useGlobalStore from '@/back/js/store/global';
import useRoute from '@/commons/js/useRoute';
import { EmitterContext } from "@/back/js/contexts/EmitterContext";

export default function TableSearch(props) {

    const getTranslation = useGlobalStore(state => state.getTranslation);
    const appData = useGlobalStore(state => state.getAppData);
    const link = useRef('');
    const [on, off, emit] = useContext(EmitterContext);

    let obj_params = {};

    if(appData('siteConfig').multilang == 1){
        obj_params['lang'] = appData('currentLang');
    }
    let [route] = useRoute( appData('name')+ '.create', obj_params)

    useEffect(() => {
        console.log('TableSearch.jsx onMounted', appData());
    }, [])

    const doSearch = (e) => {
        console.log(e);
        let input = e.target;
        emit('adminify:table:search', {
            search : input.value.trim(),
            page : 1
        })
    }

    const HandleGo = (item) => {
        
        emit('adminify:router:change', {
            url: item.url,
            method: 'get',
            form: {},
            data: {}
        });
        // router.visit(item.url, {
        //     method : 'get',
        //     data: {}
        // })
    }

    return <>
        <div class="col d-flex justify-content-end align-items-center text-right">
            <FloatingLabel controlId="floatingPassword" label={getTranslation('admin.table.modules.search')}>
                <Form.Control type="text" onKeyUp={doSearch} placeholder={getTranslation('admin.table.modules.search')} />
            </FloatingLabel>
            <div class="ml-lg-3 mt-3 mt-lg-0">
                <button onClick={() => { HandleGo({url: route}) }} class="btn btn-sm btn-primary"> {getTranslation('admin.table.modules.btn_create')}</button>
            </div>
        </div>
    </>
}