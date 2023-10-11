import React, { forwardRef, createRef, useEffect, useMemo } from "react";
import Accordion from 'react-bootstrap/Accordion';
import Button from 'react-bootstrap/Button';
import useHelpers from '../../hooks/useHelpers';

 const SortableItem = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({});
    }

    let item = useMemo(() => props.node, [props]);
    let fields = useMemo(() => props.fields, [props]);
    // const styleForDragChildZone = !isDraging ? defaultDragChildZoneStyles : dragingChildZoneStyles;


    useEffect(() => {
        // console.log('SortableItem.jsx onMounted', props);
        console.log('SortableItem.jsx onMounted', props);

    }, [])

    const handleDelete = (e) => {
        e.preventDefault();
        e.stopPropagation();
        console.log('handleDelete() in SortableItem', e)
    }

    return <div {...props}>
                  <Accordion.Item ref={ref}>
                      <Accordion.Header as="div">
                              <Button as="div" {...props} className="handle">Drag</Button>
                              <Button as="div" variant="danger" onClick={handleDelete}>remove</Button>                    
                              {item.title}
                          </Accordion.Header>
                          <Accordion.Body>
                            {fields ? fields : null}
                            Grose tata
                          </Accordion.Body>
                          {/* <SortableZone data-sortable-id={newSortableId} isRoot={false} sortableId={ newSortableId } sortableConfig={updateSortableConfig()}  prototype={prototype} /> */}
                  </Accordion.Item>
            </div>
        
    
                    
 })

 export default SortableItem;