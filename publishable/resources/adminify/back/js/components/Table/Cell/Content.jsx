import React, { forwardRef, useEffect, createRef } from "react";
import useTranslations from "../../../hooks/useTranslations";

const Content = forwardRef((props, ref) => {

    const { get } = useTranslations();

    useEffect(() => {
        if(!ref) {
            ref = createRef({});
        }
    }, [])

    const renderContent = (value, attr) => {
        let entity = get('admin.table.th_cells.'+attr);
        let lbl = 'admin.table.modules.listings.has_entity';
        if(!value) {
            lbl = 'admin.table.modules.listings.no_entity';
        }

        return get(lbl)
    }

    return <>
        <td ref={ref}>
            {renderContent(props.data.model[props.data.real_attr], props.data.real_attr)} 
        </td>
    </>


});

export default Content;