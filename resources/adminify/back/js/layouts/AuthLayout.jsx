import React, { useEffect, useState } from 'react'

import Loader from '../components/Loader';

import useAdminifyDefaults from '../hooks/useAdminifyDefaults';
import { EmitterContext } from "../contexts/EmitterContext";

export default function AuthLayout(component) {
    

    // const [on, off, emit] = useEmitter();
    // const [createHttp, http] = useAxios();
    const { on, off, emit, onRouterChange, onAjax, onFormSubmit  } = useAdminifyDefaults();

    onRouterChange()
    onAjax()
    onFormSubmit()

    return <EmitterContext.Provider value={[on, off, emit]}>
            <div className='container h-100'>
                <div className='row h-100'>
                    {component.children}
                </div>
            </div>
            
            <Loader className="h-100 position-fixed"/>
        </EmitterContext.Provider>
}