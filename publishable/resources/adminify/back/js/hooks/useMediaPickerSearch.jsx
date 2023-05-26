import React,{ useEffect, useRef, useContext } from 'react';
import { EmitterContext } from "@/back/js/contexts/EmitterContext";
import useAxios from '@/back/js/hooks/useAxios';
import Route from '@/commons/js/Route';

export default function useMediaPickerSearch(props = {}, additionalsDefaultsQueries = {}) {
    const [on, off, emit] = useContext(EmitterContext);
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

        let mediaListing = Route('medias.listing', {});
        
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
