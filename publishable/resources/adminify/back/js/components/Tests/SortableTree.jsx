import React, { createRef, forwardRef, useState, useCallback, useEffect } from 'react';
import useHelpers from '../../hooks/useHelpers';
import { DndProvider } from 'react-dnd'
import { HTML5Backend } from 'react-dnd-html5-backend'
import SortableItem from "../Tests/SortableItem";
import SortableList from './SortableList';

const SortableTree = forwardRef((props, ref) => {

    if(!ref) {
        ref = createRef({});
    }

    const [list, setList] = useState(props.items ?? []);
    const { event, fire } = useHelpers();

    const defaultRenderNode = (item, index, array) => {

        let previous_index = index;

        const getItems = (item) => {
            let rt = [];
            if(item.children && item.children.length > 0) {
                rt = item.children;
            }
            return rt;
        }

        let subItems = getItems(item);

        return <SortableItem type="root" index={index}>
                    {item.name}
                    {/* {subItems} */}
                    <SortableList renderNodes={rendererForNodes} type="child" className="child-list" items={subItems} />
               </SortableItem>
    }

    const compareArray = (a, b) => {
        return JSON.stringify(a) === JSON.stringify(b);
    }


    const defaultChangeSorter = useCallback((datas) => {
        // console.log("", datas, list)
        let { dragIndex , hoverIndex} = datas
        const dragItem = list[dragIndex]
        const hoverItem = list[hoverIndex] 

        const updatedPets = [...list]
        updatedPets[dragIndex] = hoverItem
        updatedPets[hoverIndex] = dragItem

        let isSame = compareArray(updatedPets, list);
            // Swap places of dragItem and hoverItem in the pets array
        if(!isSame) {
            console.log("", list,  updatedPets)

            setList(localList => updatedPets)
        }
    }, [list])

    const rendererForNodes = props.renderNode && props.renderNode instanceof Function ? props.renderNode : defaultRenderNode;
    const onChangeCb = props.onChange && props.onChange instanceof Function ? props.onChange : defaultChangeSorter;

    event('menubuilder:update', onChangeCb) 

    useEffect(() => {
        console.log('updated list', list)
    }, [list])

    if(!list) {
        return null;
    }

    console.log("rerender sortabletree", list);

    return <DndProvider ref={ref} backend={HTML5Backend}>
                <SortableList renderNodes={rendererForNodes} className='root-tree' type="root" items={list} />
            </DndProvider>
})

export default SortableTree;