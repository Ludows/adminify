import React, { useState, useEffect, useRef} from 'react';
import SortableZone from './SortableZone';
import useMenu from "../../hooks/useMenu";
import useHelpers from '../../hooks/useHelpers';

function SortableThree(props) {
    const [items, setItems] = useState([]);
    
    const { event, fire } = useHelpers();
    const [dragingInfos, setDragInfos] = useState({
        isOnDrag : false,
        type : null,
        event : {}
    });

    const defaultConfigSortables = {
        handle : '.handle',
        group : 'nested',
        onStart : onStartDrag,
        onChange: onMoveDrag,
        onEnd : onEndDrag,
        list: items,
        setList: function(newState) {
            fire('menubuilder:update', {
                state: newState, 
                isRoot: true,
                isUpdate: dragingInfos.isOnDrag,
                fromSortableId: 0,
                sortableId : 0,
                isNew : false,
                event : dragingInfos
            })
        }
    }

    function onMoveDrag(evt) {
        setDragInfos({
            isOnDrag: true,
            type : 'change',
            event : evt
        });
    }

    function onStartDrag(evt) {
        setDragInfos({
            isOnDrag: true,
            type : 'start',
            event : evt
        });
    }

    function onEndDrag(evt) {
        setDragInfos({
            isOnDrag: false,
            type : 'end',
            event : evt
        });
    }

    function handleUpdates(datas) {
        if(!datas.event) {
            datas.event = dragingInfos;
        }
        setItemsRecords(datas);
    }

    event('menubuilder:update', handleUpdates)

    function setItemsRecords(object = {}) {

        const { state , isRoot, sortableId, isNew, fromSortableId, isUpdate, item, event} = object;

        console.log('SortableThree.jsx setRecords', object);
        
        // setItems(newState);
        if(isRoot && isNew) {
            setItems((items) => [...items, ...state.items]);
        }
        if(fromSortableId != sortableId && isUpdate && state.length > 0) {
            console.log('update from child list :)')
            setItems((items) => {
                return items.map((localItem) => {
                    if(localItem.uuid == item.uuid && event.isOnDrag == false) {
                        localItem.children = state;
                    }
                })
            })
        }
        if(fromSortableId === sortableId && isUpdate) {
            console.log('update from the same list :)')
            setItems(() => state.items ? [...state.items] : [...state]);
        }
        
    }

    const { onItems, prototype } = useMenu({
        ...props
    });

    const onItemsCb = (datas) => {
        setItemsRecords({
            state: datas, 
            isRoot: true,
            fromSortableId: 0,
            sortableId : 0,
            isNew : true
        });
    }

    onItems(onItemsCb);

    useEffect(() => {
        // console.log('SortableThree.jsx mounted', props, defaultConfigSortables)
    }, [])

    useEffect(() => {
        console.log('render items', items)
    }, [items])

    return <>
        <SortableZone isRoot={true} sortableConfig={{...defaultConfigSortables}} data-sortable-id="0"  sortableId={0} prototype={prototype} />
    </>
}

export default SortableThree;