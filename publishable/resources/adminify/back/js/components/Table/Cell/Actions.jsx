import React, { forwardRef, useEffect, createRef } from "react";
import DropdownActions from "../../Dropdowns/DropdownActions";

const Actions = forwardRef((props, ref) => {
    
    useEffect(() => {
        if(!ref) {
            ref = createRef({});
        }
    }, [])

    return <td ref={ref}>
            <DropdownActions actions={props.data.dropdown} />
        </td>
    


});

export default Actions;