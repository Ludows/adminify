import React, { useEffect, useMemo } from 'react';
import useHelpers from '../hooks/useHelpers';
import usePageProps from '../hooks/usePageProps';
import ContentTypesTitleRenderer from './ContentTypesTitleRenderer';
export default function ContentTypesRenderer(props) {
    

    const { filterObjects } = useHelpers();
    const { get } = usePageProps();

    const leftColumn = useMemo(() => {
        return filterObjects(props.fields, (field) => props.leftFields.includes(field.real_name))
    }, [props]);
    const rightColumn = useMemo(() => {
        return filterObjects(props.fields, (field) => props.rightFields.includes(field.real_name))
    }, [props]);
    
    const leftColumnKeys = Object.keys(leftColumn);
    const rightColumnKeys = Object.keys(rightColumn);
    const isEdit = get('isEdit');
    const model = get('model');

    useEffect(() => {
        console.log('ContentTypesRenderer.jsx mounted', props);
    }, [])


    return <div className='row'>
        <div className='col-12 col-lg-7'>
            <div className='card mb-3'>
                <div className='card-body'>
                    <ContentTypesTitleRenderer model={model} isEdit={isEdit} renderField={props.renderField} field={props.fields.title} />
                </div>
            </div>
            { leftColumnKeys.map((key, index, array) => {
                return props.renderField(index, leftColumn[key]);
            })}

        </div>
        <div className='col-12 col-lg-5'>
            <div className='card'>
                <div className='card-body'>
                    {rightColumnKeys.map((key, index, array) => {
                        return props.renderField(index, rightColumn[key]);
                    })}
                </div>
            </div>
            
        </div>
    </div>
}