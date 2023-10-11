import React, { createRef, forwardRef, useState, useMemo } from 'react';
import useHelpers from '../../hooks/useHelpers';
import { useDrag, useDrop } from 'react-dnd'

const SortableList = forwardRef((props, ref) => {

    let items = useMemo(() => props.items, [props]);
    let renderNodes = props.renderNodes ? props.renderNodes : () => {};
    const withType = useState(props.type ?? 'root');


    return <div {...props}>
        {items.map(renderNodes)}
    </div>
})

export default SortableList;