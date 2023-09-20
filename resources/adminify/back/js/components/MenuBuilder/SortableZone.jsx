import React, { forwardRef, createRef, useEffect, useState } from "react";
import Accordion from 'react-bootstrap/Accordion';
import SortableItem from "./SortableItem";
import { ReactSortable } from "react-sortablejs";


 const SortableZone = forwardRef((props, ref) => {
    if(!ref) {
        ref = createRef({});
    }

   const { isRoot, prototype, sortableConfig, sortableId, allowForChilds } = props;

    if(!sortableConfig.list) {
        return <>No Items</>;
    }
   
    return <Accordion ref={ref}  defaultActiveKey="0">
        <ReactSortable data-sortable-id={sortableId} {...sortableConfig}>
            {sortableConfig.list.map((item, idx) => {
                let fields = prototype ? prototype(item, idx) : null;
                return <SortableItem key={idx} allowForChilds={true} fromSortableId={sortableId} fields={fields} prototype={prototype} item={item} sortableConfig={{...sortableConfig}} eventKey={idx} /> 
            })}
        </ReactSortable>
    </Accordion> 
   
 })

 export default SortableZone;