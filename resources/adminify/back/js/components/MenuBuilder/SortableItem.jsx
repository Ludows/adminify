import React, { forwardRef, createRef, useEffect, useMemo } from "react";
import SortableZone from "./SortableZone";
import Accordion from 'react-bootstrap/Accordion';
import Button from 'react-bootstrap/Button';
import useHelpers from '../../hooks/useHelpers';
import * as uuid from "uuid";

 const SortableItem = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({});
    }

    const { fire } = useHelpers();
    const { fields, item, isRoot, prototype, fromSortableId, sortableConfig } = props;

    if(item) {
      item.uuid = uuid.v4();
    }

      const newSortableId = useMemo(() => uuid.v4() , [])
      const defaultDragChildZoneStyles = {
        minHeight: ''
      }

      const dragingChildZoneStyles = {
        border: '1px dashed red',
        minHeight: '50px'
      }

    function updateSortableConfig() {
      if(sortableConfig) {
        sortableConfig.list = item.children;
        sortableConfig.setList = (newState) => {
            fire('menubuilder:update', {
                state: newState, 
                isRoot: false,
                isUpdate : true,
                fromSortableId: fromSortableId,
                sortableId : newSortableId,
                item, 
                isNew : false
            });
          }
      }
      return sortableConfig;
    }

      // const styleForDragChildZone = !isDraging ? defaultDragChildZoneStyles : dragingChildZoneStyles;

    useEffect(() => {
        // console.log('SortableItem.jsx onMounted', props);
    }, [])

    const handleDelete = (e) => {
        e.preventDefault();
        e.stopPropagation();
        console.log('tata')
    }

    return <Accordion.Item ref={ref} {...props}>
              <Accordion.Header as="div">
                      <Button as="div" className="handle">Drag</Button>
                      <Button as="div" variant="danger" onClick={handleDelete}>remove</Button>                    
                      {item.title}
                  </Accordion.Header>
                  <Accordion.Body>
                    {fields ? fields : null}
                  </Accordion.Body>
                  <SortableZone data-sortable-id={newSortableId} isRoot={false} sortableId={ newSortableId } sortableConfig={updateSortableConfig()}  prototype={prototype} />
          </Accordion.Item>    
    
                    
 })

 export default SortableItem;