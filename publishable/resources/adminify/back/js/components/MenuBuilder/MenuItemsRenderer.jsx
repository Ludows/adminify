import React, { forwardRef, createRef, useState, useMemo, useEffect, useCallback } from "react";
import useHelpers from "../../hooks/useHelpers";
// import '@nosferatu500/react-sortable-tree/style.css'; // This only needs to be imported once in your app
// import ReactSortable from "../Sortable";
import SortableTree from "../Tests/SortableTree";
 const MenuItemsRenderer = forwardRef((props, ref) => {
    
    const { filterObjects, event, fire } = useHelpers();

    if(!ref) {
        ref = createRef({});
    }

    let headerFields = useMemo(() => {
        return filterObjects(props.fields, (val, key) => {
            // console.log("", key, val);
            return ['title', '_token', '_method'].indexOf(key) !== -1;
        })
    }, [])

    let bodyFields = useMemo(() => {
        return filterObjects(props.fields, (val, key) => {
            // console.log("", key, val);
            return ['items'].indexOf(key) !== -1;
        })
    }, [])

    let footerFields = useMemo(() => {
        return filterObjects(props.fields, (val, key) => {
            // console.log("", key, val);
            return ['submit'].indexOf(key) !== -1;
        })
    }, [])

    const getProtoItems = () => {
        return bodyFields['items'].prototype;
    }

    const getProtoPatternName = () => {
        return bodyFields['items'].prototype_name;
    }


    // const renderWithPrototype = (item, idx) => {

    //     let proto = getProtoItems();
    //     let proto_name = getProtoPatternName();

    //     let sanitized_fields = [];
    //     let fields = {...proto.fields};
    //     Object.keys(fields).forEach((key, localIndex) => {
    //         let f = getMappedField(fields[key], proto_name, idx);
    //         sanitized_fields.push( props.renderField(localIndex, f) )
    //     })

    //     return sanitized_fields;
    // }

    const initialItems = [
        { id: "1", name: "Unread" },
        { id: "2", name: "Threads" },
        {
            id: "3",
            name: "Chat Rooms", 
            children: [
            { id: "c1", name: "General" },
            { id: "c2", name: "Random" },
            { id: "c3", name: "Open Source Projects" },
            ],
        },
        {
            id: "4",
            name: "Direct Messages",
            children: [
            // { id: "d1", name: "Alice",  children: [
            //     {id: "d1", name: "Another ALice"}
                
            // ] },
            // { id: "d2", name: "Bob" },
            // { id: "d3", name: "Charlie" },
            ],
        },
    ];


    let prototypeItems = getProtoItems();
    let prototype_name = getProtoPatternName();


    return <div ref={ref}>
            <div className="card-header">
                {Object.keys(headerFields).map((fieldKey, index, array) => {
                    let Comp = () => props.renderField(index, props.fields[fieldKey]);
                    return <Comp/>
                })}
            </div>
            <div className="card-body">
                    <SortableTree items={initialItems} />
                    {/* <SortableZone useDnd={true} items={items} /> */}
            </div>
            <div className="card-footer">
                {Object.keys(footerFields).map((fieldKey, index, array) => {
                    let Comp = () => props.renderField(index, props.fields[fieldKey]);
                    return <Comp/>
                })}
            </div>
        </div>
 })

 export default MenuItemsRenderer;