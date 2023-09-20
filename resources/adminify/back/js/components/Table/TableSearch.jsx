import React, { useEffect, useState } from 'react';
import FloatingLabel from 'react-bootstrap/FloatingLabel';
import Form from 'react-bootstrap/Form';
import useRoute from '../../hooks/useRoute';
import useHelpers from '../../hooks/useHelpers';
import usePageProps from '../../hooks/usePageProps';
import useTranslations from '../../hooks/useTranslations';
import { useDebounce } from 'usehooks-ts';
export default function TableSearch(props) {

    const { get } = useTranslations();
    const [value, setValue] = useState();
    const { tableSearch, navigate } = useHelpers();
    const { get:appData } = usePageProps();
    const debouncedValue = useDebounce(value , 500);

    let obj_params = {};

    if(appData('siteConfig').multilang == 1){
        obj_params['lang'] = appData('currentLang');
    }
    let { get:route, has } = useRoute();
    let createRoute = null;
    if(has( appData('name')+ '.create' ) ) {
        createRoute = route( appData('name') + '.create');
    }

    useEffect(() => {
        // console.log('TableSearch.jsx onMounted', appData());
        // tableSearch({
        //     search : input.value.trim(),
        //     page : 1
        // })
    }, [])

    useEffect(() => {
        // Do fetch here...
        // Triggers when "debouncedValue" changes
        tableSearch({
            search : debouncedValue,
            page : 1
        })
      }, [debouncedValue])

    const doSearch = (e) => {
        console.log(e);
        let input = e.target;
        setValue(input.value.trim());
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
                {createRoute && 
                    <button onClick={() => { HandleGo({url: createRoute}) }} class="btn btn-sm btn-primary"> {get('admin.table.modules.btn_create')}</button>
                }
            </div>
        </div>
    </>
}