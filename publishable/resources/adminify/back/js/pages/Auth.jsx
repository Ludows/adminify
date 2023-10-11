import React from 'react';
import FormCard from '../components/Cards/FormCard';
import AuthRenderer from '../components/Custom/AuthRenderer';

export default function Auth(props) {

    return <div className='col-12'>
        <FormCard useHeader={false} render={AuthRenderer} />
    </div>
}