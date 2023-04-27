import React, { useEffect } from 'react';
import BaseForm from '@/back/js/components/BaseForm';
import useGlobalStore from '@/back/js/store/global';

export default function Card(props) {

    const getTranslation = useGlobalStore(state => state.getTranslation);
    const appData = useGlobalStore(state => state.getAppData);

    return <>
        <div className='card'>
            <div className='card-header'>
                {appData('name')}
            </div>
            <div className='card-body'>
                <BaseForm form={appData('form')} />
            </div>
        </div>
    </>
}