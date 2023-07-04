import React, { useEffect } from 'react';
import BaseForm from '@/back/js/components/BaseForm';
import usePageProps from '../../hooks/usePageProps';
export default function FormCard(props) {
    const { get } = usePageProps();

    return <>
        <div className='card'>
            <div className='card-header'>
                {get('name')}
            </div>
            <div className='card-body'>
                <BaseForm form={get('form')} />
            </div>
        </div>
    </>
}