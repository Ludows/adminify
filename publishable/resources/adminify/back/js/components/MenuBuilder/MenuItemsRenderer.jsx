import React, { forwardRef, createRef, useState, useMemo, useEffect, useCallback } from "react";
import useHelpers from "../../hooks/useHelpers";
import useMenu from "../../hooks/useMenu";
import SortableThree from "./SortableThree";
// import ReactSortable from "../Sortable";
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

    return <div ref={ref}>
            <div className="card-header">
                {Object.keys(headerFields).map((fieldKey, index, array) => {
                    let Comp = () => props.renderField(index, props.fields[fieldKey]);
                    return <Comp/>
                })}
            </div>
            <div className="card-body">
                {/* <SortableZone isRoot={true} renderWithPrototype={renderWithPrototype} items={items} setItems={setItems} /> */}
                <SortableThree prototype={getProtoItems()} prototype_name={getProtoPatternName()} renderField={props.renderField} />
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