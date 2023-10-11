import React,{ useEffect, useRef, useContext } from 'react';
import { AdminifyContext } from "../contexts/AdminifyContext";
import useAxios from '../hooks/useAxios';
import useHelpers from './useHelpers';
import Route from '../libs/Route';

export default function useTableSearch(props = {}, additionalsDefaultsQueries = {}) {

    const {on, off, emit} = useContext(AdminifyContext);
    let [createHttp, http] = useAxios();
    const { onTableSearch, tableResults } = useHelpers();

    const defaultsQueryParams = useRef({
        page : 1,
        search : '',
        status : 1,
        singular : props.datas.name,
        table : props.datas.table,
        ...additionalsDefaultsQueries
    });

    const triggerSearchHandler = (datas) => {

        defaultsQueryParams.current = {
            ...defaultsQueryParams.current,
            ...datas
        };
    

        console.log('search', defaultsQueryParams.current);
        let routeListings = Route('admin.listings', {});
        
        createHttp(routeListings, {
            method: 'post',
            data: defaultsQueryParams.current,
            headers : { 'X-Inertia' : true },
            responseType : 'json',
            timeout: 10000,
        });

        http((error, datas) => {
            if(error) {
                console.log('whoops', error);
                emit("adminify:table:errors", error.data.errors);
                return false;
            }

            tableResults({
                result : datas.data.datas,
                payload: defaultsQueryParams.current
            });
            // console.log('response', datas);
        })

    }

    onTableSearch(triggerSearchHandler, [])

    return [];
}
