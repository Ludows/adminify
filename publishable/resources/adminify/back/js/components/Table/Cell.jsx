import React, { forwardRef, useEffect, createRef } from "react";

const Cell = forwardRef((props, ref) => {

    useEffect(() => {
        if(!ref) {
            ref = createRef({});
        }
    }, [])

    if(!props.model[props.data.real_attr]) {
        return <>
            <td ref={ref}>@todo</td>
        </>
    }

    return <>
        <td ref={ref}>{props.model[props.data.real_attr]}</td>
    </>


});

export default Cell;