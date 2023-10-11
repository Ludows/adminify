import React, { forwardRef, useEffect, createRef } from "react";

const User = forwardRef((props, ref) => {

    useEffect(() => {
        if(!ref) {
            ref = createRef({});
        }
    }, [])

    return <>
        <td ref={ref}>
            { props.model['user'].name } 
        </td>
    </>


});

export default User;