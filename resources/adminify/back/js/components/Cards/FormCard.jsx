import React, { useEffect } from 'react';
import BaseForm from '@/back/js/components/BaseForm';
import usePageProps from '../../hooks/usePageProps';
import useHelpers from '../../hooks/useHelpers';
export default function FormCard(props) {
    const { get } = usePageProps();
    const { empty, createCustomRenderer } = useHelpers();
    let useHeader = !empty(props) && props.hasOwnProperty('useHeader') ? props.useHeader : true;
    let useTitle = !empty(props) && props.hasOwnProperty('overrideTitle') ? props.overrideTitle : get('name');
    let useForm = !empty(props) && props.hasOwnProperty('form') ? props.form : get('form');

    let customRender = createCustomRenderer(null, props);

    if(customRender) {
        return customRender;
    }


    return <div className='card'>
                {useHeader &&
                    <div className='card-header'>
                        {useTitle}
                    </div>
                }
                <div className='card-body'>
                    <BaseForm form={useForm} />
                </div>
            </div>
}