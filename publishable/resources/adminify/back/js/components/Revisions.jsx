import React, { createRef, forwardRef } from 'react';
import usePageProps from '../hooks/usePageProps';
import Revision from './Revision';
import ListGroup from 'react-bootstrap/ListGroup';
import RevisionViewer from './Modal/RevisionViewer';
import { Portal } from 'react-portal';
import useHelpers from '../hooks/useHelpers';

const Revisions = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({});
    }

    const { get, has } = usePageProps();
    const hasRevisions = has('revisions');
    const revisions = get('revisions');
    

    if(!hasRevisions) {
        return null;
    }

    const { createCustomRenderer } = useHelpers();

    let customRender = createCustomRenderer(null, {...props, ...{hasRevisions, revisions}}, ref); 

    if(customRender) {
        return customRender;
    }
     
    return <>
        <ListGroup ref={ref} as="ul" className='mt-3'>
            {revisions.map((item, index, array) => {
                return <Revision idx={ index + 1 } item={item} key={index} />;
            })}
        </ListGroup>
        
        <Portal>
            <RevisionViewer />
        </Portal>
    </>
});

export default Revisions;