import React, { useCallback } from 'react';
import Route from '../libs/Route';
export default function useRoute() {
   
    const getCb = useCallback((name = '', parameters = {}) => {
        return Route(name, parameters);
    }, [])

    const hasCb = useCallback((name = '') => {
        return window.LaravelRoutes.hasOwnProperty(name);
    }, [])

    let methods = {
        get : getCb,
        has : hasCb
    }
    
    return methods;
}