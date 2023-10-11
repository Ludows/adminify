import React,{ useEffect, useRef, useContext } from 'react';
import { AdminifyContext } from "../contexts/AdminifyContext";
import useAxios from '../hooks/useAxios';
import Route from '../libs/Route';

export default function useMediaPickerSearch(props = {}, additionalsDefaultsQueries = {}) {
    const {on, off, emit} = useContext(AdminifyContext);
    let [createHttp, http] = useAxios();

    const defaultsQueryParams = useRef({
        page : 1,
        search : '',
        documents : '',
        date : '',
        ...additionalsDefaultsQueries
    });

    const triggerSearchHandler = (datas) => {

        defaultsQueryParams.current = {
            ...defaultsQueryParams.current,
            ...datas
        };

        let mediaListing = Route('admin.medias.listing', {});
        
        createHttp(mediaListing, {
            method: 'post',
            data: defaultsQueryParams.current,
            responseType : 'json',
            timeout: 10000,
        });

        http((error, datas) => {
            if(error) {
                console.log('whoops', error);
                emit("adminify:mediapicker:errors", error.data.errors);
                return false;
            }

            emit("adminify:mediapicker:results", {
                result : datas.data,
                payload: defaultsQueryParams.current
            });

            // console.log('response', datas);
        })
    
    }

    useEffect(() => {
        on('adminify:mediapicker:search', triggerSearchHandler);

        return () => {
            off('adminify:mediapicker:search', triggerSearchHandler);
        }
    }, [])

    return []
}
