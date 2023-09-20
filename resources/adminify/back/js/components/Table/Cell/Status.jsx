import React, { forwardRef, useEffect, createRef } from "react";

const Status = forwardRef((props, ref) => {

    useEffect(() => {
        if(!ref) {
            ref = createRef({});
        }
    }, [])

    return <>
        <td ref={ref}>
            { props.model['status'].name } 
        </td>
    </>


});

export default Status;