
import React, {useCallback, useRef} from 'react';
import { createAxios } from '@/helpers/index';
export default function useAxios() {
    const axiosInstance = useRef({})

    const createAxiosHook = useCallback((url = '', datas = {}, config = {}) => {
        axiosInstance.current = createAxios(url, datas, config);
    }, [])

    const httpCallerHook = useCallback((cb = () => {}) => {
        axiosInstance.current.then((data) => {
            cb(null, data);
        })
        .catch((error) => {
            cb(error, {});
        })
    }, [])

    return [createAxiosHook, httpCallerHook];
}
