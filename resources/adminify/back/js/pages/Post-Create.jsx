import React from 'react';
import usePageProps from '../hooks/usePageProps';
import BaseForm from '../components/BaseForm';
import ContentTypesRenderer from '../components/ContentTypesRenderer';

export default function Create(props) {

    const { get } = usePageProps();
    const theForm = get('form');
    const leftFields = ['content',  'user_id', '_token', '_method'];
    const rightFields = ['categories', 'media_id', 'status_id', 'tags', 'submit'];

    return <BaseForm render={ContentTypesRenderer} leftFields={leftFields} rightFields={rightFields} form={ theForm } />
}