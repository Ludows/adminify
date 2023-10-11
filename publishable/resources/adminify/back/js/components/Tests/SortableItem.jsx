import React, { createRef, forwardRef, useRef } from 'react';
import useHelpers from '../../hooks/useHelpers';
import { useDrag, useDrop } from 'react-dnd'

const SortableItem = forwardRef((props, ref) => {


    const { fire } = useHelpers();

    const uref = useRef(null)

    // useDrag - the list item is draggable
    const [{ isDragging }, dragRef] = useDrag({
        type: 'item',
        item: { index: props.index },
        collect: (monitor) => ({
            isDragging: monitor.isDragging(),
        }), 
    }) 

    // useDrop - the list item is also a drop area
    const [spec, dropRef] = useDrop({
        accept: 'item', 
        hover: (item, monitor) => {
            const dragIndex = item.index
            const hoverIndex = props.index;
            const hoverBoundingRect = uref.current?.getBoundingClientRect()
            const hoverMiddleY = (hoverBoundingRect.bottom - hoverBoundingRect.top) / 2
            const hoverActualY = monitor.getClientOffset().y - hoverBoundingRect.top

            // if dragging down, continue only when hover is smaller than middle Y
            if (dragIndex < hoverIndex && hoverActualY < hoverMiddleY) return 
            // if dragging up, continue only when hover is bigger than middle Y
            if (dragIndex > hoverIndex && hoverActualY > hoverMiddleY) return

            fire('menubuilder:update', {
                dragIndex, 
                hoverIndex
            })
            // props.onChange && props.onChange instanceof Function ? props.onChange(dragIndex, hoverIndex) : defaultSorter(dragIndex, hoverIndex);
            item.index = hoverIndex
        },
    })


    const dragDropRef = dragRef(dropRef(uref))

    // console.log('dragDropRef', dragDropRef)

    return <div {...props} ref={dragDropRef} className='sortable-item'>{props.children}</div>
})

export default SortableItem;