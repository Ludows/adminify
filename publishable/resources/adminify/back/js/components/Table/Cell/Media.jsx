import React, { forwardRef, useEffect, createRef } from "react";

const Media = forwardRef((props, ref) => {

    useEffect(() => {
        if(!ref) {
            ref = createRef({});
        }
    }, [])

    const renderIcon = (value) => {
        let iconCls = 'bi-file-image-fill';
        if(!value) {
            iconCls = "bi-file-x-fill";
        }

        return <i class={`bi ${iconCls}`}></i>
    }

    return <>
        <td ref={ref}>
            {renderIcon(props.data.model[props.data.real_attr])} 
        </td>
    </>


});

export default Media;