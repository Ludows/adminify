
import React, {useCallback, useRef, useContext} from 'react';
import { EmitterContext } from "@/back/js/contexts/EmitterContext";

export default function useHelpers() {

    const [on, off, emit] = useContext(EmitterContext);

    let navigateCb = useCallback((object) => {
        let defaults = {
            form: {},
            data : {},
            method : 'get',
            url : ''
        };
        let final = {...defaults, ...object};
        emit('adminify:router:change', final);
    })
    
    let methods = {
        navigate : navigateCb
    }

    return methods;
}
